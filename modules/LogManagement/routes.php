<?php

use Illuminate\Support\Facades\Route;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogIntent;

// Service Item
Route::prefix('student-log')->group(function () {
    Route::middleware('auth:web')->post('/create-student-log', CreateStudentLogIntent::class)->name('student-log.create-student-log');
});
