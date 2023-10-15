<?php

use App\Http\Controllers\Evaluation\EvaluationController;
use Illuminate\Support\Facades\Route;

Route::prefix('evaluation')->middleware(['auth'])->group(function () {
    
    Route::get('/', [EvaluationController::class, 'show'])->name('evaluation.show');
});
