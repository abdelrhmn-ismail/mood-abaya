<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\PageController;

Route::get('/about', fn () => app(PageController::class)->show('about'))->name('about');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show')->where('slug', '[a-z0-9\-]+');