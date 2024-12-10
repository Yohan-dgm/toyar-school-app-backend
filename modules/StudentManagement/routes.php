<?php

use Illuminate\Support\Facades\Route;
use Modules\StudentManagement\Intents\Student\GetStudentListData\GetStudentListDataIntent;

// Program
Route::prefix('student')->group(function () {
    Route::middleware('auth:web')->post('/get-student-list-data', GetStudentListDataIntent::class)->name('student.get-student-list-data');
});
