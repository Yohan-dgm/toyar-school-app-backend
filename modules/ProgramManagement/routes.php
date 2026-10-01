<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\ProgramManagement\Intents\GradeLevel\GetGradeLevelListData\GetGradeLevelListDataIntent;
use Modules\ProgramManagement\Intents\GradeLevel\GetGradeLevelsWithClasses\GetGradeLevelsWithClassesIntent;
use Modules\ProgramManagement\Intents\Program\GetProgramListData\GetProgramListDataIntent;
use Modules\ProgramManagement\Intents\Program\UpdateProgram\UpdateProgramIntent;
use Modules\ProgramManagement\Intents\ProgramManagement\AttachSubjectListToEducator\AttachSubjectListToEducatorIntent;
use Modules\ProgramManagement\Intents\Sport\GetSportListData\GetSportListDataIntent;
use Modules\ProgramManagement\Intents\Subject\GetSubjectListData\GetSubjectListDataIntent;

// Program
Route::prefix('program')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-program-list-data', GetProgramListDataIntent::class)->name('program.get-program-list-data');
    Route::middleware(AuthGuard::class)->post('/update-program', UpdateProgramIntent::class)->name('program.update-program');
});
// program-management
Route::prefix('program-management')->group(function () {
    Route::middleware(AuthGuard::class)->post('/attach-subject-list-to-educator', AttachSubjectListToEducatorIntent::class)->name('program-management.attach-subject-list-to-educator');
});
// grade-level
Route::prefix('grade-level')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-grade-level-list-data', GetGradeLevelListDataIntent::class)->name('grade-level.get-grade-level-list-data');
    Route::middleware(AuthGuard::class)->post('/get-grade-levels-with-classes', GetGradeLevelsWithClassesIntent::class)->name('grade-level.get-grade-levels-with-classes');
});
// subject
Route::prefix('subject')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-subject-list-data', GetSubjectListDataIntent::class)->name('subject.get-subject-list-data');
});

// sport
Route::prefix('sport')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-sport-list-data', GetSportListDataIntent::class)->name('sport.get-sport-list-data');
});
