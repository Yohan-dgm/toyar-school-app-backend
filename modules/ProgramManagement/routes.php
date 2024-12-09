<?php

use Illuminate\Support\Facades\Route;
use Modules\ProgramManagement\Intents\Program\GetProgramListData\GetProgramListDataIntent;

// Program
Route::prefix('program')->group(function () {
    Route::middleware('auth:web')->post('/get-program-list-data', GetProgramListDataIntent::class)->name('program.get-program-list-data');
});
