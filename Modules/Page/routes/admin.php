<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\Admin\PageContentController;

Route::get('/page-contents', [PageContentController::class, 'index'])->name('page-contents.index');
Route::get('/page-contents/{pageContent}/edit', [PageContentController::class, 'edit'])->name('page-contents.edit');
Route::put('/page-contents/{pageContent}', [PageContentController::class, 'update'])->name('page-contents.update');