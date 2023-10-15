<?php

use App\Http\Controllers\Help\SuggestionController;
use Illuminate\Support\Facades\Route;

Route::prefix('help/suggestions')->middleware(['auth'])->group(function () {
    
    Route::get('/', [SuggestionController::class, 'show'])->name('help.suggestion.show');
});
