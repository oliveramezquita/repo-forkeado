<?php

use App\Http\Controllers\Utility\LogController;
use Illuminate\Support\Facades\Route;

Route::prefix('utility/log')->middleware(['auth'])->group(function () {
    
    Route::get('/', [LogController::class, 'show'])->name('utility.log.show');
});
