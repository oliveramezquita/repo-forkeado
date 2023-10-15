<?php

use App\Http\Controllers\Evaluation\SessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('evaluation/session')->middleware(['auth'])->group(function () {
    
    Route::get('/', [SessionController::class, 'show'])->name('evaluation.session.show');
});
