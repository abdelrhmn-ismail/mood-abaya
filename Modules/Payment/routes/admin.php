<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\Admin\PaymentController;

Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::post('/payments/bulk', [PaymentController::class, 'bulkAction'])->name('payments.bulk');
Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
Route::post('/payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
Route::post('/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.markPaid');
