<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display the shopping cart page.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $discount = session()->get('discount', 0.00);
        $promoCode = session()->get('promo_code', null);

        // Ensure discount does not exceed subtotal
        if ($discount > $subtotal) {
            $discount = $subtotal;
        }

        $grandTotal = max(0, $subtotal - $discount);

        return view('cart.index', compact('cart', 'subtotal', 'discount', 'grandTotal', 'promoCode'));
    }

    /**
     * Add a vehicle product to the shopping cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'brand' => $product->brand,
                'model_year' => $product->model_year,
                'price' => (float) $product->price,
                'image_url' => $product->image_url,
                'stock' => $product->stock,
                'quantity' => $quantity,
            ];
        }

        session()->put('cart', $cart);

        $cartCount = array_sum(array_column($cart, 'quantity'));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "{$product->name} added to cart!",
                'cartCount' => $cartCount,
                'cart' => $cart,
            ]);
        }

        return redirect()->back()->with('success', "{$product->name} added to your cart!");
    }

    /**
     * Update vehicle quantity in cart.
     */
    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $action = $request->input('action'); // 'increase', 'decrease', or direct 'quantity'

            if ($action === 'increase') {
                $cart[$id]['quantity']++;
            } elseif ($action === 'decrease') {
                $cart[$id]['quantity']--;
                if ($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
            } elseif ($request->filled('quantity')) {
                $qty = (int) $request->quantity;
                if ($qty <= 0) {
                    unset($cart[$id]);
                } else {
                    $cart[$id]['quantity'] = $qty;
                }
            }

            session()->put('cart', $cart);
        }

        // Recompute totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $discount = session()->get('discount', 0);
        if ($discount > $subtotal) {
            $discount = $subtotal;
            session()->put('discount', $discount);
        }
        $grandTotal = max(0, $subtotal - $discount);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'cartCount' => $cartCount,
                'itemSubtotal' => isset($cart[$id]) ? number_format($cart[$id]['price'] * $cart[$id]['quantity'], 2) : 0,
                'itemQuantity' => isset($cart[$id]) ? $cart[$id]['quantity'] : 0,
                'subtotal' => number_format($subtotal, 2),
                'discount' => number_format($discount, 2),
                'grandTotal' => number_format($grandTotal, 2),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    /**
     * Remove vehicle item from shopping cart.
     */
    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $name = $cart[$id]['name'];
            unset($cart[$id]);
            session()->put('cart', $cart);

            // Recheck discount
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            if (session()->get('discount', 0) > $subtotal) {
                session()->put('discount', $subtotal);
            }

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "{$name} removed from cart.",
                    'cartCount' => array_sum(array_column($cart, 'quantity')),
                ]);
            }

            return redirect()->route('cart.index')->with('success', "{$name} removed from cart.");
        }

        return redirect()->route('cart.index');
    }

    /**
     * Apply promotional coupon code.
     */
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $code = strtoupper(trim($request->coupon_code));
        $discount = 0.00;

        if ($code === 'VIP100') {
            $discount = 100.00;
        } elseif ($code === 'LUXURY500') {
            $discount = 500.00;
        } elseif ($code === 'ELITE10') {
            // 10% discount calculated on subtotal
            $cart = session()->get('cart', []);
            $subtotal = 0;
            foreach ($cart as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            $discount = round($subtotal * 0.10, 2);
        } else {
            return redirect()->back()->with('error', "Invalid promo code '{$code}'. Try using 'VIP100' or 'LUXURY500'.");
        }

        session()->put('promo_code', $code);
        session()->put('discount', $discount);

        return redirect()->route('cart.index')->with('success', "Promo code '{$code}' applied! Saved $" . number_format($discount, 2));
    }

    /**
     * Remove active promo coupon.
     */
    public function removeCoupon()
    {
        session()->forget('promo_code');
        session()->forget('discount');

        return redirect()->route('cart.index')->with('success', 'Promo code removed.');
    }

    /**
     * Clear all cart contents.
     */
    public function clear()
    {
        session()->forget('cart');
        session()->forget('promo_code');
        session()->forget('discount');

        return redirect()->route('cart.index')->with('success', 'Cart cleared.');
    }
}
