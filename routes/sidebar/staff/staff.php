<?php

use App\Http\Controllers\Staff\StaffController;
use Illuminate\Support\Facades\Route;

Route::prefix('staff')->middleware(['auth'])->group(function () {
    
    Route::get('/', [StaffController::class, 'show'])->name('staff.show');
});
