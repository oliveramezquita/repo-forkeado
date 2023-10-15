<?php

use App\Http\Controllers\Finance\BalanceController;
use Illuminate\Support\Facades\Route;

Route::prefix('finance/balance')->middleware(['auth'])->group(function () {
    
    Route::get('/', [BalanceController::class, 'show'])->name('finance.balance.show');
});
