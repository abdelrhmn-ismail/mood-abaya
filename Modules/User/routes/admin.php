<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Admin\UserController;

Route::get('/users', [UserController::class, 'index'])->name('users.index');