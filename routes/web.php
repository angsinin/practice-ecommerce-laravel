<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

/*
|--------------------------------------------------------------------------
| Web Routes - Luxury Automotive E-Commerce
|--------------------------------------------------------------------------
*/

// Product Catalog
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('products.show');

// Shopping Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::match(['post', 'patch'], '/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::match(['post', 'delete'], '/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
Route::post('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout & Order Placement
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

// Order Confirmation
Route::get('/order/confirmation/{order_number}', [CheckoutController::class, 'confirmation'])->name('order.confirmation');
