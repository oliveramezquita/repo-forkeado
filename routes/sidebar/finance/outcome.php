<?php

use App\Http\Controllers\Finance\OutcomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('finance/outcome')->middleware(['auth'])->group(function () {
    
    Route::get('/', [OutcomeController::class, 'show'])->name('finance.outcome.show');
});
