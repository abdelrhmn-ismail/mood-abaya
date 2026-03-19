<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\Admin\DashboardController;

Route::get('/', DashboardController::class)->name('dashboard');
