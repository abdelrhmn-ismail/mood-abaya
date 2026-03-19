<?php

use Illuminate\Support\Facades\Route;
use Modules\Newsletter\Http\Controllers\Admin\NewsletterSubscriberController;

Route::get('/newsletter', [NewsletterSubscriberController::class, 'index'])->name('newsletter.index');
Route::post('/newsletter/bulk', [NewsletterSubscriberController::class, 'bulkAction'])->name('newsletter.bulk');