<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Frontend routes (/, /about, /categories, /cart, /contact, etc.) are registered by Core, Shop, Contact, Cart modules.

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/account', [\App\Http\Controllers\AccountController::class, 'index'])->name('account')->middleware('verified');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
