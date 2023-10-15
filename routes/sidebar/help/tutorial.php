<?php

use App\Http\Controllers\Help\TutorialController;
use Illuminate\Support\Facades\Route;

Route::prefix('help/tutorials')->middleware(['auth'])->group(function () {
    
    Route::get('/', [TutorialController::class, 'show'])->name('help.tutorial.show');
});
