<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\CategoryController;
use Modules\Admin\Http\Controllers\ContactMessageController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\OrderController;
use Modules\Admin\Http\Controllers\PaymentController;
use Modules\Admin\Http\Controllers\ProductController;
use Modules\Admin\Http\Controllers\SettingsController;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::post('/orders/{order}/ship', [OrderController::class, 'ship'])->name('orders.ship');

Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
Route::post('/payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
Route::post('/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.markPaid');

Route::get('/contacts', [ContactMessageController::class, 'index'])->name('contacts.index');
Route::get('/contacts/{contactMessage}', [ContactMessageController::class, 'show'])->name('contacts.show');

Route::resource('categories', CategoryController::class)->except('show');
Route::resource('products', ProductController::class)->except('show');
