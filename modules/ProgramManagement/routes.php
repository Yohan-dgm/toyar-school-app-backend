<?php

use Illuminate\Support\Facades\Route;
use Modules\ProgramManagement\Intents\Program\GetProgramListData\GetProgramListDataIntent;
use Modules\ProgramManagement\Intents\SubjectListToEducator\AttachSubjectListToEducator\AttachSubjectListToEducatorIntent;

// Program
Route::prefix('program')->group(function () {
    Route::middleware('auth:web')->post('/get-program-list-data', GetProgramListDataIntent::class)->name('program.get-program-list-data');
    Route::middleware('auth:web')->post('/attach_educator_subject', AttachSubjectListToEducatorIntent::class)->name('program.attach_educator_subject');
});
