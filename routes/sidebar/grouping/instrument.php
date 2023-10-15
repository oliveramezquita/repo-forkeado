<?php

use App\Http\Controllers\Grouping\InstrumentController;
use Illuminate\Support\Facades\Route;

Route::prefix('grouping/instruments')->middleware(['auth'])->group(function () {
    
    Route::get('/', [InstrumentController::class, 'show'])->name('grouping.instrument.show');
});
