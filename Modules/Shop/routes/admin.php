<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\Admin\CategoryController;
use Modules\Shop\Http\Controllers\Admin\ProductController;
use Modules\Shop\Http\Controllers\Admin\ProductVariantController;
use Modules\Shop\Http\Controllers\Admin\ReviewController;

Route::post('categories/bulk', [CategoryController::class, 'bulkAction'])->name('categories.bulk');
Route::resource('categories', CategoryController::class)->except('show');

Route::post('products/bulk', [ProductController::class, 'bulkAction'])->name('products.bulk');
Route::post('products/{product}/variants', [ProductVariantController::class, 'store'])->name('products.variants.store');
Route::delete('products/{product}/variants/{variant}', [ProductVariantController::class, 'destroy'])->name('products.variants.destroy');
Route::resource('products', ProductController::class)->except('show');

Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
Route::post('/reviews/bulk', [ReviewController::class, 'bulkAction'])->name('reviews.bulk');
Route::post('/reviews/{review}/toggle-visibility', [ReviewController::class, 'toggleVisibility'])->name('reviews.toggle-visibility');
