<?php

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\Admin\FaqController;

Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
Route::get('/faqs/create', [FaqController::class, 'create'])->name('faqs.create');
Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
Route::get('/faqs/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');