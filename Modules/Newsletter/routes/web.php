<?php

use Illuminate\Support\Facades\Route;
use Modules\Newsletter\Http\Controllers\NewsletterController;

Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');