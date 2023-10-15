<?php

use App\Http\Controllers\Admin\SchoolSettingsController;
use Illuminate\Support\Facades\Route;

Route::prefix('settings')->middleware(['auth'])->group(function () {

    Route::get('/create', [SchoolSettingsController::class, 'create'])->name('school.settings.create');
    Route::post('/', [SchoolSettingsController::class, 'store'])->name('school.settings.store');
    Route::get('/', [SchoolSettingsController::class, 'edit'])->name('school.settings.edit');
    Route::patch('/', [SchoolSettingsController::class, 'update'])->name('school.settings.update');
});