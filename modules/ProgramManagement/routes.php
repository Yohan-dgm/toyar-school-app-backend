<?php

use Illuminate\Support\Facades\Route;
use Modules\ProgramManagement\Intents\Program\GetProgramListData\GetProgramListDataIntent;
use Modules\ProgramManagement\Intents\ProgramManagement\AttachSubjectListToEducator\AttachSubjectListToEducatorIntent;

// Program
Route::prefix('program')->group(function () {
    Route::middleware('auth:web')->post('/get-program-list-data', GetProgramListDataIntent::class)->name('program.get-program-list-data');
});
// program-management
Route::prefix('program-management')->group(function () {
    Route::middleware('auth:web')->post('/attach-subject-list-to-educator', AttachSubjectListToEducatorIntent::class)->name('program-management.attach-subject-list-to-educator');
});
