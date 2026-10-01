<?php

namespace Modules\TimetableManagement;

use Illuminate\Support\Facades\Route;
use Modules\TimetableManagement\Intents\AcademicTimetable\BulkCreateAcademicTimetable\BulkCreateAcademicTimetableIntent;
use Modules\TimetableManagement\Intents\AcademicTimetable\CreateAcademicTimetable\CreateAcademicTimetableIntent;
use Modules\TimetableManagement\Intents\AcademicTimetable\GetAcademicTimetableAggregatedListData\GetAcademicTimetableAggregatedListDataIntent;
use Modules\TimetableManagement\Intents\AcademicTimetable\GetAcademicTimetableListData\GetAcademicTimetableListDataIntent;
use Modules\TimetableManagement\Intents\AcademicTimetable\UpdateAcademicTimetable\UpdateAcademicTimetableIntent;
use Modules\TimetableManagement\Intents\SportTimetable\BulkCreateSportTimetable\BulkCreateSportTimetableIntent;
use Modules\TimetableManagement\Intents\SportTimetable\CreateSportTimetable\CreateSportTimetableIntent;
use Modules\TimetableManagement\Intents\SportTimetable\GetSportTimetableAggregatedListData\GetSportTimetableAggregatedListDataIntent;
use Modules\TimetableManagement\Intents\SportTimetable\GetSportTimetableListData\GetSportTimetableListDataIntent;
use Modules\TimetableManagement\Intents\SportTimetable\UpdateSportTimetable\UpdateSportTimetableIntent;

// Academic Timetable
// Route::prefix('academic-timetable')->group(function () {
//     Route::middleware('auth:web')->post('/create-academic-timetable', CreateAcademicTimetableIntent::class)->name('academic-timetable.create-academic-timetable');
//     Route::middleware('auth:web')->post('/update-academic-timetable', UpdateAcademicTimetableIntent::class)->name('academic-timetable.update-academic-timetable');
//     Route::middleware('auth:web')->post('/get-academic-timetable-list-data', GetAcademicTimetableListDataIntent::class)->name('academic-timetable.get-academic-timetable-list-data');
//     Route::middleware('auth:web')->post('/get-academic-timetable-aggregated-list-data', GetAcademicTimetableAggregatedListDataIntent::class)->name('academic-timetable.get-academic-timetable-aggregated-list-data');
//     Route::middleware('auth:web')->post('/bulk-create-academic-timetable', BulkCreateAcademicTimetableIntent::class)->name('academic-timetable.bulk-create-academic-timetable');
// });

// Sport Timetable
Route::prefix('sport-timetable')->group(function () {
    Route::middleware('auth:web')->post('/create-sport-timetable', CreateSportTimetableIntent::class)->name('sport-timetable.create-sport-timetable');
    Route::middleware('auth:web')->post('/update-sport-timetable', UpdateSportTimetableIntent::class)->name('sport-timetable.update-sport-timetable');
    Route::middleware('auth:web')->post('/get-sport-timetable-list-data', GetSportTimetableListDataIntent::class)->name('sport-timetable.get-sport-timetable-list-data');
    Route::middleware('auth:web')->post('/get-sport-timetable-aggregated-list-data', GetSportTimetableAggregatedListDataIntent::class)->name('sport-timetable.get-sport-timetable-aggregated-list-data');
    Route::middleware('auth:web')->post('/bulk-create-sport-timetable', BulkCreateSportTimetableIntent::class)->name('sport-timetable.bulk-create-sport-timetable');
});
