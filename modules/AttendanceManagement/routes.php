<?php

namespace Modules\AttendanceManagement;

use Illuminate\Support\Facades\Route;
use Modules\AttendanceManagement\Intents\EducatorAttendance\CreateEducatorAttendance\CreateEducatorAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\CreateStudentAttendance\CreateStudentAttendanceIntent;

// Attendance
Route::prefix('attendance')->group(function () {
    Route::middleware('auth:web')->post('/create-educator-attendance', CreateEducatorAttendanceIntent::class)->name('attendance.create-educator-attendance');
    Route::middleware('auth:web')->post('/create-student-attendance', CreateStudentAttendanceIntent::class)->name('attendance.create-student-attendance');
});
