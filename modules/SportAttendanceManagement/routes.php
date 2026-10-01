<?php

namespace Modules\SportAttendanceManagement;

use Illuminate\Support\Facades\Route;
use Modules\SportAttendanceManagement\Intents\SportAttendance\BulkCreateSportAttendance\BulkCreateSportAttendanceIntent;
use Modules\SportAttendanceManagement\Intents\SportAttendance\CreateSportAttendance\CreateSportAttendanceIntent;
use Modules\SportAttendanceManagement\Intents\SportAttendance\GetSportAttendanceAggregatedListData\GetSportAttendanceAggregatedListDataIntent;
use Modules\SportAttendanceManagement\Intents\SportAttendance\GetSportAttendanceListData\GetSportAttendanceListDataIntent;
use Modules\SportAttendanceManagement\Intents\SportAttendance\UpdateSportAttendance\UpdateSportAttendanceIntent;

// SportAttendance
Route::prefix('sport-attendance')->group(function () {
    Route::middleware('auth:web')->post('/create-sport-attendance', CreateSportAttendanceIntent::class)->name('sport-attendance.create-sport-attendance');
    Route::middleware('auth:web')->post('/update-sport-attendance', UpdateSportAttendanceIntent::class)->name('sport-attendance.update-sport-attendance');
    Route::middleware('auth:web')->post('/get-sport-attendance-list-data', GetSportAttendanceListDataIntent::class)->name('sport-attendance.get-sport-attendance-list-data');
    Route::middleware('auth:web')->post('/get-sport-attendance-aggregated-list-data', GetSportAttendanceAggregatedListDataIntent::class)->name('sport-attendance.get-sport-attendance-aggregated-list-data');
    Route::middleware('auth:web')->post('/bulk-create-sport-attendance', BulkCreateSportAttendanceIntent::class)->name('sport-attendance.bulk-create-sport-attendance');
});
