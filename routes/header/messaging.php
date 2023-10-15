<?php

use App\Http\Controllers\Messaging\MessagingController;
use Illuminate\Support\Facades\Route;

Route::prefix('messaging')->middleware(['auth'])->group(function () {
    
    Route::get('/', [MessagingController::class, 'show'])->name('messaging.show');
});
