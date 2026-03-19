<?php

use Illuminate\Support\Facades\Route;
use Modules\Order\Http\Controllers\Admin\OrderController;

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export');
Route::post('/orders/bulk', [OrderController::class, 'bulkAction'])->name('orders.bulk');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::post('/orders/{order}/ship', [OrderController::class, 'ship'])->name('orders.ship');
