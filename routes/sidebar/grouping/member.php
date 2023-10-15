<?php

use App\Http\Controllers\Grouping\MemberController;
use Illuminate\Support\Facades\Route;

Route::prefix('grouping/members')->middleware(['auth'])->group(function () {
    
    Route::get('/', [MemberController::class, 'show'])->name('grouping.member.show');
});
