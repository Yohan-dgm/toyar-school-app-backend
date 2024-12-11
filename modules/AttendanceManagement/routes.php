<?php

namespace Modules\AttendanceManagement;

use Illuminate\Support\Facades\Route;
use Modules\AttendanceManagement\Intents\EducatorAttendance\CreateEducatorAttendance\CreateEducatorAttendanceIntent;
use Modules\AttendanceManagement\Intents\EducatorAttendance\EditEducatorAttendance\EditEducatorAttendanceIntent;
use Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceListData\GetEducatorAttendanceListDataIntent;
use Modules\AttendanceManagement\Intents\EducatorLeave\CreateEducatorLeave\CreateEducatorLeaveIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\BulkCreateStudentAttendance\BulkCreateStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\CreateStudentAttendance\CreateStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\EditStudentAttendance\EditStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceListData\GetStudentAttendanceListDataIntent;

// EducatorAttendance
Route::prefix('educator-attendance')->group(function () {
    Route::middleware('auth:web')->post('/create-educator-attendance', CreateEducatorAttendanceIntent::class)->name('educator-attendance.create-educator-attendance');
    Route::middleware('auth:web')->post('/edit-educator-attendance', EditEducatorAttendanceIntent::class)->name('educator-attendance.edit-educator-attendance');
    Route::middleware('auth:web')->post('/get-educator-attendance-list-data', GetEducatorAttendanceListDataIntent::class)->name('educator-attendance.get-educator-attendance-list-data');
});

// StudentAttendance
Route::prefix('student-attendance')->group(function () {
    Route::middleware('auth:web')->post('/create-student-attendance', CreateStudentAttendanceIntent::class)->name('student-attendance.create-student-attendance');
    Route::middleware('auth:web')->post('/edit-student-attendance', EditStudentAttendanceIntent::class)->name('student-attendance.edit-student-attendance');
    Route::middleware('auth:web')->post('/get-student-attendance-list-data', GetStudentAttendanceListDataIntent::class)->name('student-attendance.get-student-attendance-list-data');
    Route::middleware('auth:web')->post('/bulk-create-student-attendance', BulkCreateStudentAttendanceIntent::class)->name('student-attendance.bulk-create-student-attendance');
});



// EducatorLeave
Route::prefix('educator-leave')->group(function () {
    Route::middleware('auth:web')->post('/create-educator-leave', CreateEducatorLeaveIntent::class)->name('educator-leave.create-educator-leave');
});