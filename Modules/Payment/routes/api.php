<?php

use Illuminate\Support\Facades\Route;
use Modules\Payment\Http\Controllers\TabbyController;

// Tabby webhook — no CSRF verification needed
Route::post('/tabby/webhook', [TabbyController::class, 'webhook'])->name('tabby.webhook');
