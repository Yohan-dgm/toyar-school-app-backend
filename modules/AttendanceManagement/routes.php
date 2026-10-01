<?php

namespace Modules\AttendanceManagement;

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\AttendanceManagement\Intents\EducatorAttendance\BulkCreateEducatorAttendance\BulkCreateEducatorAttendanceIntent;
use Modules\AttendanceManagement\Intents\EducatorAttendance\CreateEducatorAttendance\CreateEducatorAttendanceIntent;
use Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceAggregatedListData\GetEducatorAttendanceAggregatedListDataIntent;
use Modules\AttendanceManagement\Intents\EducatorAttendance\GetEducatorAttendanceListData\GetEducatorAttendanceListDataIntent;
use Modules\AttendanceManagement\Intents\EducatorAttendance\UpdateEducatorAttendance\UpdateEducatorAttendanceIntent;
use Modules\AttendanceManagement\Intents\Leave\CreateLeave\CreateLeaveIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\BatchCreateStudentAttendance\BatchCreateStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\BatchUpdateStudentAttendance\BatchUpdateStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\BulkCreateStudentAttendance\BulkCreateStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\CreateStudentAttendance\CreateStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\DeleteStudentAttendance\DeleteStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceAggregatedListData\GetStudentAttendanceAggregatedListDataIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceByDateAndClass\GetStudentAttendanceByDateAndClassIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceByGrade\GetStudentAttendanceByGradeIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceById\GetStudentAttendanceByIdIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceListData\GetStudentAttendanceListDataIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\GetTodayStudentAttendance\GetTodayStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\GetTodayStudentAttendanceByStudentId\GetTodayStudentAttendanceByStudentIdIntent;
use Modules\AttendanceManagement\Intents\StudentAttendance\UpdateStudentAttendance\UpdateStudentAttendanceIntent;
use Modules\AttendanceManagement\Intents\Stats\GetStudentAttendanceStats\GetStudentAttendanceStatsIntent;

// EducatorAttendance
// Route::prefix('educator-attendance')->group(function () {
//     Route::middleware('auth:web')->post('/create-educator-attendance', CreateEducatorAttendanceIntent::class)->name('educator-attendance.create-educator-attendance');
//     Route::middleware('auth:web')->post('/update-educator-attendance', UpdateEducatorAttendanceIntent::class)->name('educator-attendance.update-educator-attendance');
//     Route::middleware('auth:web')->post('/get-educator-attendance-list-data', GetEducatorAttendanceListDataIntent::class)->name('educator-attendance.get-educator-attendance-list-data');
//     Route::middleware('auth:web')->post('/get-educator-attendance-aggregated-list-data', GetEducatorAttendanceAggregatedListDataIntent::class)->name('educator-attendance.get-student-attendance-aggregated-list-data');
//     Route::middleware('auth:web')->post('/bulk-create-educator-attendance', BulkCreateEducatorAttendanceIntent::class)->name('educator-attendance.bulk-create-educator-attendance');
// });

// // StudentAttendance
// Route::prefix('student-attendance')->group(function () {
//     Route::middleware('auth:web')->post('/create-student-attendance', CreateStudentAttendanceIntent::class)->name('student-attendance.create-student-attendance');
//     Route::middleware('auth:web')->post('/update-student-attendance', UpdateStudentAttendanceIntent::class)->name('student-attendance.update-student-attendance');
//     Route::middleware('auth:web')->post('/get-student-attendance-list-data', GetStudentAttendanceListDataIntent::class)->name('student-attendance.get-student-attendance-list-data');
//     Route::middleware('auth:web')->post('/get-student-attendance-aggregated-list-data', GetStudentAttendanceAggregatedListDataIntent::class)->name('student-attendance.get-student-attendance-aggregated-list-data');
//     Route::middleware('auth:web')->post('/bulk-create-student-attendance', BulkCreateStudentAttendanceIntent::class)->name('student-attendance.bulk-create-student-attendance');
// });

// // Leave
// Route::prefix('leave')->group(function () {
//     Route::middleware('auth:web')->post('/create-leave', CreateLeaveIntent::class)->name('leave.create-leave');
// });

Route::prefix('student-attendance')->group(function () {
    // New batch processing endpoints (primary methods)
    Route::middleware(AuthGuard::class)->post('/batch-create-student-attendance', BatchCreateStudentAttendanceIntent::class)->name('student-attendance.batch-create-student-attendance');
    Route::middleware(AuthGuard::class)->post('/batch-update-student-attendance', BatchUpdateStudentAttendanceIntent::class)->name('student-attendance.batch-update-student-attendance');

    // Legacy individual endpoints (kept for backward compatibility)
    Route::middleware(AuthGuard::class)->post('/create-student-attendance', CreateStudentAttendanceIntent::class)->name('student-attendance.create-student-attendance');
    Route::middleware(AuthGuard::class)->post('/bulk-create-student-attendance', BulkCreateStudentAttendanceIntent::class)->name('student-attendance.bulk-create-student-attendance');
 
    // Enhanced CRUD operations
    Route::middleware(AuthGuard::class)->post('/update-student-attendance', UpdateStudentAttendanceIntent::class)->name('student-attendance.update-student-attendance');
    Route::middleware(AuthGuard::class)->post('/delete-student-attendance', DeleteStudentAttendanceIntent::class)->name('student-attendance.delete-student-attendance');

    // Data retrieval endpoints (enhanced with reasons)
    Route::middleware(AuthGuard::class)->post('/get-student-attendance-by-date-and-class', GetStudentAttendanceByDateAndClassIntent::class)->name('student-attendance.get-student-attendance-by-date-and-class');
    Route::middleware(AuthGuard::class)->post('/get-student-attendance-by-grade', GetStudentAttendanceByGradeIntent::class)->name('student-attendance.get-student-attendance-by-grade');
    Route::middleware(AuthGuard::class)->post('/get-student-attendance-aggregated-list-data', GetStudentAttendanceAggregatedListDataIntent::class)->name('student-attendance.get-student-attendance-aggregated-list-data');
    Route::middleware(AuthGuard::class)->post('/get-student-attendance-list-data', GetStudentAttendanceListDataIntent::class)->name('student-attendance.get-student-attendance-list-data');
    Route::middleware(AuthGuard::class)->post('/get-student-attendance-by-id', GetStudentAttendanceByIdIntent::class)->name('student-attendance.get-student-attendance-by-id');
    Route::middleware(AuthGuard::class)->post('/get-today-student-attendance', GetTodayStudentAttendanceIntent::class)->name('student-attendance.get-today-student-attendance');
    Route::middleware(AuthGuard::class)->post('/get-today-student-attendance-by-student-id', GetTodayStudentAttendanceByStudentIdIntent::class)->name('student-attendance.get-today-student-attendance-by-student-id');

    // Statistics Endpoints
    Route::middleware(AuthGuard::class)->post('/stats/student-attendance-stats', GetStudentAttendanceStatsIntent::class)->name('student-attendance.stats.student-attendance-stats');
});
