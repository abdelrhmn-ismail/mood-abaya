<?php

use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\HomeController;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', fn () => app(\App\Http\Controllers\PageController::class)->show('about'))->name('about');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
// /categories and /categories/{slug}, /products/{slug} are handled by Shop module
// /cart is handled by Cart module
// /contact is handled by Contact module

// Auth: login, register, logout are in routes/auth.php (Breeze)
