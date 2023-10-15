<?php

use App\Http\Controllers\Teacher\SignatureController;
use Illuminate\Support\Facades\Route;

Route::prefix('teacher/signature')->middleware(['auth'])->group(function () {
    
    Route::get('/', [SignatureController::class, 'show'])->name('teacher.signature.show');
});
