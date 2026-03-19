<?php

use Illuminate\Support\Facades\Route;
use Modules\Contact\Http\Controllers\Admin\ContactMessageController;

Route::get('/contacts', [ContactMessageController::class, 'index'])->name('contacts.index');
Route::post('/contacts/bulk', [ContactMessageController::class, 'bulkAction'])->name('contacts.bulk');
Route::get('/contacts/{contactMessage}', [ContactMessageController::class, 'show'])->name('contacts.show');
