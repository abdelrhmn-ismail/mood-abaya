<?php

use Illuminate\Support\Facades\Route;

// Frontend (Material Tailwind)
Route::get('/', function () {
    return view('frontend.home');
})->name('home');
