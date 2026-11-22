<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your shopping cart is currently empty. Please select a vehicle first.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = session()->get('discount', 0.00);
        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        // Shipping options
        $shippingOptions = [
            'Standard Showroom Pickup' => 0.00,
            'Flatbed Home Delivery' => 50.00,
            'VIP Enclosed Transport' => 150.00,
        ];

        $defaultShipping = 'Standard Showroom Pickup';
        $shippingFee = $shippingOptions[$defaultShipping];
        $grandTotal = max(0, $subtotal + $shippingFee - $discount);

        return view('checkout.index', compact('cart', 'subtotal', 'discount', 'shippingOptions', 'defaultShipping', 'shippingFee', 'grandTotal'));
    }

    /**
     * Process and place the customer order.
     */
    public function process(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('products.index')->with('error', 'Your cart is empty. Please select a luxury vehicle.');
        }

        // Strict Laravel validation
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:30',
            'address' => 'required|string|max:500',
            'shipping_method' => 'required|string|in:Standard Showroom Pickup,Flatbed Home Delivery,VIP Enclosed Transport',
            'payment_method' => 'required|string|in:Cash on Delivery (COD) / Pay at Showroom,Bank Transfer / KHQR,Credit / Debit Card,Digital Wallet (ABA Pay / Wing / Bakong)',
        ], [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'email.required' => 'A valid email address is required for your purchase receipt.',
            'phone.required' => 'Phone number is required for delivery logistics.',
            'address.required' => 'Please provide a valid delivery or billing address.',
            'shipping_method.required' => 'Please choose a shipping / delivery method.',
            'payment_method.required' => 'Please select your preferred payment method.',
        ]);

        // Calculate shipping fee
        $shippingFee = 0.00;
        if ($validated['shipping_method'] === 'Flatbed Home Delivery') {
            $shippingFee = 50.00;
        } elseif ($validated['shipping_method'] === 'VIP Enclosed Transport') {
            $shippingFee = 150.00;
        }

        // Calculate subtotal from cart
        $subtotal = 0.00;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = (float) session()->get('discount', 0.00);
        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        $grandTotal = max(0, $subtotal + $shippingFee - $discount);

        // Execute DB Transaction
        $order = DB::transaction(function () use ($validated, $cart, $shippingFee, $discount, $subtotal, $grandTotal) {
            // 1. Create or Find Customer
            $customer = Customer::create([
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
            ]);

            // 2. Generate unique Order ID e.g., ORD-0001
            $lastOrder = Order::orderBy('id', 'desc')->first();
            $nextId = $lastOrder ? ($lastOrder->id + 1) : 1;
            $orderNumber = 'ORD-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

            // Double check uniqueness
            while (Order::where('order_number', $orderNumber)->exists()) {
                $nextId++;
                $orderNumber = 'ORD-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
            }

            // 3. Create Order
            $order = Order::create([
                'order_number' => $orderNumber,
                'customer_id' => $customer->id,
                'shipping_method' => $validated['shipping_method'],
                'shipping_fee' => $shippingFee,
                'discount' => $discount,
                'payment_method' => $validated['payment_method'],
                'subtotal' => $subtotal,
                'grand_total' => $grandTotal,
                'order_status' => 'Pending',
                'payment_status' => 'Pending',
            ]);

            // 4. Create Order Items
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
                $unitPrice = $product ? (float) $product->price : (float) $item['price'];
                $itemSubtotal = $unitPrice * $item['quantity'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'unit_price' => $unitPrice,
                    'subtotal' => $itemSubtotal,
                ]);

                // Decrement stock if available
                if ($product && $product->stock >= $item['quantity']) {
                    $product->decrement('stock', $item['quantity']);
                }
            }

            return $order;
        });

        // 5. Clear Cart & Sessions
        session()->forget('cart');
        session()->forget('promo_code');
        session()->forget('discount');

        return redirect()->route('order.confirmation', ['order_number' => $order->order_number])
            ->with('success', 'Your vehicle order has been successfully placed!');
    }

    /**
     * Display order confirmation page.
     */
    public function confirmation($order_number)
    {
        $order = Order::with(['customer', 'orderItems.product'])
            ->where('order_number', $order_number)
            ->firstOrFail();

        return view('orders.confirmation', compact('order'));
    }
}
