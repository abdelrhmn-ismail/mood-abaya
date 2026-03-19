<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AccountController;
use Modules\User\Http\Controllers\ProfileController;

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'index'])->name('account')->middleware('verified');
    Route::get('/account/orders/{orderNumber}', [AccountController::class, 'showOrder'])->name('orders.show')->middleware('verified');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
