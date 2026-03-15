<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\CategoryController;
use Modules\Admin\Http\Controllers\ContactMessageController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\OrderController;
use Modules\Admin\Http\Controllers\PageContentController;
use Modules\Admin\Http\Controllers\PaymentController;
use Modules\Admin\Http\Controllers\ProductController;
use Modules\Admin\Http\Controllers\ReviewController;
use Modules\Admin\Http\Controllers\SettingsController;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
Route::get('/translations', [SettingsController::class, 'translations'])->name('translations.index');
Route::put('/translations', [SettingsController::class, 'updateTranslations'])->name('translations.update');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::post('/orders/bulk', [OrderController::class, 'bulkAction'])->name('orders.bulk');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
Route::post('/orders/{order}/ship', [OrderController::class, 'ship'])->name('orders.ship');

Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::post('/payments/bulk', [PaymentController::class, 'bulkAction'])->name('payments.bulk');
Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
Route::post('/payments/{payment}/approve', [PaymentController::class, 'approve'])->name('payments.approve');
Route::post('/payments/{payment}/reject', [PaymentController::class, 'reject'])->name('payments.reject');
Route::post('/payments/{payment}/mark-paid', [PaymentController::class, 'markPaid'])->name('payments.markPaid');

Route::get('/contacts', [ContactMessageController::class, 'index'])->name('contacts.index');
Route::post('/contacts/bulk', [ContactMessageController::class, 'bulkAction'])->name('contacts.bulk');
Route::get('/contacts/{contactMessage}', [ContactMessageController::class, 'show'])->name('contacts.show');

Route::post('categories/bulk', [CategoryController::class, 'bulkAction'])->name('categories.bulk');
Route::resource('categories', CategoryController::class)->except('show');
Route::post('products/bulk', [ProductController::class, 'bulkAction'])->name('products.bulk');
Route::resource('products', ProductController::class)->except('show');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews/bulk', [ReviewController::class, 'bulkAction'])->name('reviews.bulk');
Route::post('/reviews/{review}/toggle-visibility', [ReviewController::class, 'toggleVisibility'])->name('reviews.toggle-visibility');

Route::get('/page-contents', [PageContentController::class, 'index'])->name('page-contents.index');
Route::get('/page-contents/{pageContent}/edit', [PageContentController::class, 'edit'])->name('page-contents.edit');
Route::put('/page-contents/{pageContent}', [PageContentController::class, 'update'])->name('page-contents.update');
