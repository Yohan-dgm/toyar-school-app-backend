<?php

namespace Modules\ParentManagement;

use Illuminate\Support\Facades\Route;
use Modules\ParentManagement\Intents\StudentGuardian\GetStudentGuardianListData\GetStudentGuardianListDataIntent;

// StudentGuardian
Route::prefix('student-guardian')->group(function () {
    Route::middleware('auth:web')->post('/get-student-guardian-list-data', GetStudentGuardianListDataIntent::class)->name('term.get-student-guardian-list-data');
});
