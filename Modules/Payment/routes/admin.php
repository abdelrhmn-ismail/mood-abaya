<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\Admin\PaymentController;
use Modules\Payment\Http\Controllers\Admin\PaymentMethodController;

Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::post('/payments/bulk', [PaymentController::class, 'bulkAction'])->name('payments.bulk');
Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
Route::post('/payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
Route::post('/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.markPaid');

Route::get('/payment-methods', [PaymentMethodController::class, 'index'])->name('payment-methods.index');
Route::get('/payment-methods/create', [PaymentMethodController::class, 'create'])->name('payment-methods.create');
Route::post('/payment-methods', [PaymentMethodController::class, 'store'])->name('payment-methods.store');
Route::get('/payment-methods/{paymentMethod}/edit', [PaymentMethodController::class, 'edit'])->name('payment-methods.edit');
Route::put('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'update'])->name('payment-methods.update');
Route::delete('/payment-methods/{paymentMethod}', [PaymentMethodController::class, 'destroy'])->name('payment-methods.destroy');
Route::post('/payment-methods/{paymentMethod}/toggle', [PaymentMethodController::class, 'toggle'])->name('payment-methods.toggle');
