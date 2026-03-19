<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\Admin\PostController;

Route::resource('posts', PostController::class)->except('show');