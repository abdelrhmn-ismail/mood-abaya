<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\CategoryController;
use Modules\Shop\Http\Controllers\ProductController;
use Modules\Shop\Http\Controllers\SearchController;
use Modules\Shop\Http\Controllers\WishlistController;
use Modules\Shop\Http\Controllers\ReviewController;

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist', [WishlistController::class, 'store'])->name('wishlist.store');
Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy'])->name('wishlist.destroy')->where('productId', '[0-9]+');
Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/account/order-review', [ReviewController::class, 'store'])->name('account.order-review.store');
});
