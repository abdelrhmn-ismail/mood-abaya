<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\CheckoutController;
use Modules\Order\Http\Controllers\OrderController;

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order-confirmed/{orderNumber}', [OrderController::class, 'confirmed'])->name('order.confirmed');
});
