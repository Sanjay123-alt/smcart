<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// home
Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::post('/store', [ProductController::class, 'store'])->name('products.store');

// Add product to cart
Route::get('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');

// View cart
Route::get('/cart', [ProductController::class, 'showCart'])->name('cart.show');

// Remove product from cart
Route::get('/cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

//Update product from cart
Route::post('/cart/update/{id}', [ProductController::class, 'updateCart'])->name('cart.update');

// Checkout page
Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');

// Place the order
Route::post('/order', [ProductController::class, 'placeOrder'])->name('order.place');

// Order success page
Route::get('/order/success', [ProductController::class, 'success'])->name('order.success');

