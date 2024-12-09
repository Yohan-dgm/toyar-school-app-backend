<?php

namespace Modules\AttendanceManagement;

use Illuminate\Support\Facades\Route;
use Modules\AttendanceManagement\Intents\EducatorAttendance\CreateEducatorAttendance\CreateEducatorAttendanceIntent;
use Modules\AttendanceManagement\Intents\EducatorAttendance\EditEducatorAttendance\EditEducatorAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\CreateStudentAttendance\CreateStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\EditStudentAttendance\EditStudentAttendanceIntent;

// EducatorAttendance
Route::prefix('educator-attendance')->group(function () {
    Route::middleware('auth:web')->post('/create-educator-attendance', CreateEducatorAttendanceIntent::class)->name('educator-attendance.create-educator-attendance');
    Route::middleware('auth:web')->post('/edit-educator-attendance', EditEducatorAttendanceIntent::class)->name('educator-attendance.edit-educator-attendance');
});

// StudentAttendance
Route::prefix('student-attendance')->group(function () {
    Route::middleware('auth:web')->post('/create-student-attendance', CreateStudentAttendanceIntent::class)->name('student-attendance.create-student-attendance');
    Route::middleware('auth:web')->post('/edit-student-attendance', EditStudentAttendanceIntent::class)->name('student-attendance.edit-student-attendance');
});
