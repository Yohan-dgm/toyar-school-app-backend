<?php

namespace Modules\AttendanceManagement;

use Illuminate\Support\Facades\Route;
use Modules\AttendanceManagement\Intents\EducatorAttendance\CreateEducatorAttendance\CreateEducatorAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\CreateStudentAttendance\CreateStudentAttendanceIntent;

// EducatorAttendance
Route::prefix('educator-attendance')->group(function () {
    Route::middleware('auth:web')->post('/create-educator-attendance', CreateEducatorAttendanceIntent::class)->name('educator-attendance.create-educator-attendance');
});

// StudentAttendance
Route::prefix('student-attendance')->group(function () {
    Route::middleware('auth:web')->post('/create-student-attendance', CreateStudentAttendanceIntent::class)->name('student-attendance.create-student-attendance');
});
