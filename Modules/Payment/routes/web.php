<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\TabbyController;

// Tabby payment redirect endpoints (these need session/auth)
Route::get('/tabby/success',  [TabbyController::class, 'success'])->name('tabby.success');
Route::get('/tabby/failure',  [TabbyController::class, 'failure'])->name('tabby.failure');
Route::get('/tabby/cancel',   [TabbyController::class, 'cancel'])->name('tabby.cancel');
