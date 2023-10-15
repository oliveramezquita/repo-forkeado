<?php

use App\Http\Controllers\Finance\IncomeController;
use Illuminate\Support\Facades\Route;

Route::prefix('finance/income')->middleware(['auth'])->group(function () {
    
    Route::get('/', [IncomeController::class, 'show'])->name('finance.income.show');
});
