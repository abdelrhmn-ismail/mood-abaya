<?php

use Illuminate\Support\Facades\Route;
use Modules\Settings\Http\Controllers\Admin\SettingsController;

Route::get('/settings', [SettingsController::class, 'edit'])->name('settings.edit');
Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
Route::get('/settings/frontend', [SettingsController::class, 'frontend'])->name('settings.frontend');
Route::put('/settings/frontend', [SettingsController::class, 'updateFrontend'])->name('settings.frontend.update');
Route::get('/translations', [SettingsController::class, 'translations'])->name('translations.index');
Route::put('/translations', [SettingsController::class, 'updateTranslations'])->name('translations.update');