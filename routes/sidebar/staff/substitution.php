<?php

use App\Http\Controllers\Staff\SubstitutionController;
use Illuminate\Support\Facades\Route;

Route::prefix('staff/substitutions')->middleware(['auth'])->group(function () {
    
    Route::get('/', [SubstitutionController::class, 'show'])->name('staff.substitution.show');
});
