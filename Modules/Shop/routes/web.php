<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\CategoryController;
use Modules\Shop\Http\Controllers\ProductController;

Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
Route::get('/categories/{slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
