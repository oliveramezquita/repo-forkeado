<?php

use App\Http\Controllers\Evaluation\StatisticController;
use Illuminate\Support\Facades\Route;

Route::prefix('evaluation/statistics')->middleware(['auth'])->group(function () {
    
    Route::get('/', [StatisticController::class, 'show'])->name('evaluation.statistic.show');
});
