<?php

use App\Http\Controllers\Help\SupportController;
use Illuminate\Support\Facades\Route;

Route::prefix('help/support')->middleware(['auth'])->group(function () {
    
    Route::get('/', [SupportController::class, 'show'])->name('help.support.show');
});
