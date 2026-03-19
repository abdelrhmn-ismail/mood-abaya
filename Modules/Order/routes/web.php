<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\BillingAddressController;
use Modules\Order\Http\Controllers\CheckoutController;
use Modules\Order\Http\Controllers\OrderController;

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order-confirmed/{orderNumber}', [OrderController::class, 'confirmed'])->name('order.confirmed');

    Route::post('/account/billing-addresses', [BillingAddressController::class, 'store'])->name('billing-addresses.store');
    Route::put('/account/billing-addresses/{billingAddress}', [BillingAddressController::class, 'update'])->name('billing-addresses.update');
    Route::delete('/account/billing-addresses/{billingAddress}', [BillingAddressController::class, 'destroy'])->name('billing-addresses.destroy');
});
