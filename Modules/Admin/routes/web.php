<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\CategoryController;
use Modules\Admin\Http\Controllers\ContactMessageController;
use Modules\Admin\Http\Controllers\FaqController;
use Modules\Admin\Http\Controllers\DashboardController;
use Modules\Admin\Http\Controllers\OrderController;
use Modules\Admin\Http\Controllers\PageContentController;
use Modules\Admin\Http\Controllers\PaymentController;
use Modules\Admin\Http\Controllers\ProductController;
use Modules\Admin\Http\Controllers\BannerController;
use Modules\Admin\Http\Controllers\PostController;
use Modules\Admin\Http\Controllers\TestimonialController;
use Modules\Admin\Http\Controllers\ReviewController;
use Modules\Admin\Http\Controllers\SettingsController;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Admin\Http\Controllers\PresentationController;

Route::get('/', DashboardController::class)->name('dashboard');
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/presentations', [PresentationController::class, 'index'])->name('presentations.index');
Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
Route::get('/translations', [SettingsController::class, 'translations'])->name('translations.index');
Route::put('/translations', [SettingsController::class, 'updateTranslations'])->name('translations.update');

Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/orders/export', [OrderController::class, 'export'])->name('orders.export');
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

Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');

Route::post('categories/bulk', [CategoryController::class, 'bulkAction'])->name('categories.bulk');
Route::resource('categories', CategoryController::class)->except('show');
Route::post('products/bulk', [ProductController::class, 'bulkAction'])->name('products.bulk');
Route::post('products/{product}/variants', [\Modules\Admin\Http\Controllers\ProductVariantController::class, 'store'])->name('products.variants.store');
Route::delete('products/{product}/variants/{variant}', [\Modules\Admin\Http\Controllers\ProductVariantController::class, 'destroy'])->name('products.variants.destroy');
Route::resource('products', ProductController::class)->except('show');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews/bulk', [ReviewController::class, 'bulkAction'])->name('reviews.bulk');
Route::post('/reviews/{review}/toggle-visibility', [ReviewController::class, 'toggleVisibility'])->name('reviews.toggle-visibility');

Route::resource('posts', PostController::class)->except('show');
Route::resource('banners', BannerController::class);
Route::resource('testimonials', TestimonialController::class);

Route::get('/page-contents', [PageContentController::class, 'index'])->name('page-contents.index');
Route::get('/page-contents/{pageContent}/edit', [PageContentController::class, 'edit'])->name('page-contents.edit');
Route::put('/page-contents/{pageContent}', [PageContentController::class, 'update'])->name('page-contents.update');
