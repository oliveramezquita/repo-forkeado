<?php

use App\Http\Controllers\Utility\AssistanceController;
use Illuminate\Support\Facades\Route;

Route::prefix('utility/assistance')->middleware(['auth'])->group(function () {
    
    Route::get('/', [AssistanceController::class, 'show'])->name('utility.assistance.show');
});
