<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CarEcommerceTest extends TestCase
{
    /**
     * Test Catalog page loads successfully.
     */
    public function test_catalog_page_loads_with_products()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('SHOWROOM INVENTORY');
        $response->assertSee('APEX MOTORS');
    }

    /**
     * Test Adding vehicle to cart and cart view.
     */
    public function test_can_add_vehicle_to_cart_and_view_cart()
    {
        $product = Product::first();
        $this->assertNotNull($product);

        // Add to cart
        $response = $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertSessionHas('cart');
        $cart = session('cart');
        $this->assertArrayHasKey($product->id, $cart);

        // View cart
        $cartResponse = $this->get(route('cart.index'));
        $cartResponse->assertStatus(200);
        $cartResponse->assertSee($product->name);
        $cartResponse->assertSee('Proceed to Checkout');
    }

    /**
     * Test applying coupon code.
     */
    public function test_can_apply_vip_coupon_code()
    {
        $product = Product::first();
        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->post(route('cart.coupon'), [
            'coupon_code' => 'VIP100',
        ]);

        $response->assertSessionHas('discount', 100.00);
        $response->assertSessionHas('promo_code', 'VIP100');
    }

    /**
     * Test full checkout workflow and order placement.
     */
    public function test_checkout_workflow_creates_order_and_redirects_to_confirmation()
    {
        $product = Product::first();
        $this->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);
        $this->post(route('cart.coupon'), [
            'coupon_code' => 'VIP100',
        ]);

        // Visit checkout
        $checkoutResponse = $this->get(route('checkout.index'));
        $checkoutResponse->assertStatus(200);
        $checkoutResponse->assertSee('Registration Details');

        // Submit checkout
        $customerData = [
            'first_name' => 'Michael',
            'last_name' => 'Corleone',
            'email' => 'michael.c@luxurycars.com',
            'phone' => '+1 (555) 345-6789',
            'address' => '1100 Ocean Drive, Penthouse Suite, Miami, FL 33139',
            'shipping_method' => 'VIP Enclosed Transport',
            'payment_method' => 'Cash on Delivery (COD) / Pay at Showroom',
        ];

        $processResponse = $this->post(route('checkout.process'), $customerData);

        // Should redirect to confirmation
        $processResponse->assertStatus(302);
        
        $order = Order::whereHas('customer', function ($query) {
            $query->where('email', 'michael.c@luxurycars.com');
        })->latest('id')->first();

        $this->assertNotNull($order);
        $this->assertEquals('Pending', $order->order_status);
        $this->assertEquals(150.00, (float) $order->shipping_fee);
        $this->assertEquals(100.00, (float) $order->discount);
        $this->assertCount(1, $order->orderItems);

        // Confirm cart is cleared
        $this->assertEmpty(session('cart', []));

        // Test confirmation page
        $confirmResponse = $this->get(route('order.confirmation', ['order_number' => $order->order_number]));
        $confirmResponse->assertStatus(200);
        $confirmResponse->assertSee('ORDER PLACED SUCCESSFULLY!');
        $confirmResponse->assertSee($order->order_number);
        $confirmResponse->assertSee('Michael Corleone');
        $confirmResponse->assertSee('VIP Enclosed Transport');
    }

    /**
     * Test low amount 200 Riel test product with KHQR settlement flow.
     */
    public function test_low_amount_flow_with_khqr_payment()
    {
        $lowProduct = Product::where('price', 200.00)->first();
        if (!$lowProduct) {
            $lowProduct = Product::first();
        }

        // 1. Add to cart
        $addResponse = $this->post(route('cart.add'), [
            'product_id' => $lowProduct->id,
            'quantity' => 1,
        ]);
        $addResponse->assertSessionHas('cart');

        // 2. View cart
        $cartResponse = $this->get(route('cart.index'));
        $cartResponse->assertStatus(200);
        $cartResponse->assertSee('Proceed to Checkout');

        // 3. View checkout
        $checkoutResponse = $this->get(route('checkout.index'));
        $checkoutResponse->assertStatus(200);
        $checkoutResponse->assertSee('Registration Details');
        $checkoutResponse->assertSee('Ang Sinin');
        $checkoutResponse->assertSee('images/acleda-khqr.jpg');

        // 4. Place order with Bank Transfer / KHQR
        $orderData = [
            'first_name' => 'Sokha',
            'last_name' => 'Chan',
            'email' => 'sokha.chan@kh-luxury.com',
            'phone' => '+855 12 345 678',
            'address' => 'Street 2004, Sen Sok, Phnom Penh, Cambodia',
            'shipping_method' => 'Standard Showroom Pickup',
            'payment_method' => 'Bank Transfer / KHQR',
        ];

        $processResponse = $this->post(route('checkout.process'), $orderData);
        $processResponse->assertStatus(302);

        $order = Order::whereHas('customer', function ($query) {
            $query->where('email', 'sokha.chan@kh-luxury.com');
        })->latest('id')->first();

        $this->assertNotNull($order);
        $this->assertEquals('Bank Transfer / KHQR', $order->payment_method);
        $this->assertEquals('Standard Showroom Pickup', $order->shipping_method);
    }
}
