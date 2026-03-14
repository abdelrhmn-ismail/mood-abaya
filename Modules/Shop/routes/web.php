<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\CategoryController;
use Modules\Shop\Http\Controllers\ProductController;
use Modules\Shop\Http\Controllers\SearchController;

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
