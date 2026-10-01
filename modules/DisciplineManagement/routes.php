<?php

namespace Modules\DisciplineManagement;

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\DisciplineManagement\Intents\DisciplineRecord\ApproveDisciplineRecord\ApproveDisciplineRecordIntent;
use Modules\DisciplineManagement\Intents\DisciplineRecord\CreateDisciplineRecord\CreateDisciplineRecordIntent;
use Modules\DisciplineManagement\Intents\DisciplineRecord\DeleteDisciplineRecord\DeleteDisciplineRecordIntent;
use Modules\DisciplineManagement\Intents\DisciplineRecord\GetDisciplineGradeDashboard\GetDisciplineGradeDashboardIntent;
use Modules\DisciplineManagement\Intents\DisciplineRecord\GetDisciplineRecordListData\GetDisciplineRecordListDataIntent;
use Modules\DisciplineManagement\Intents\DisciplineRecord\GetStudentDisciplineSummary\GetStudentDisciplineSummaryIntent;
use Modules\DisciplineManagement\Intents\DisciplineRecord\RejectDisciplineRecord\RejectDisciplineRecordIntent;
use Modules\DisciplineManagement\Intents\DisciplineRecord\UpdateDisciplineRecord\UpdateDisciplineRecordIntent;
use Modules\DisciplineManagement\Intents\MisconductLevel\CreateMisconductLevel\CreateMisconductLevelIntent;
use Modules\DisciplineManagement\Intents\MisconductLevel\DeleteMisconductLevel\DeleteMisconductLevelIntent;
use Modules\DisciplineManagement\Intents\MisconductLevel\GetMisconductLevelListData\GetMisconductLevelListDataIntent;
use Modules\DisciplineManagement\Intents\MisconductLevel\UpdateMisconductLevel\UpdateMisconductLevelIntent;

// MisconductLevel (admin-managed master matrix)
Route::prefix('misconduct-level')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-misconduct-level', CreateMisconductLevelIntent::class)->name('misconduct-level.create-misconduct-level');
    Route::middleware(AuthGuard::class)->post('/update-misconduct-level', UpdateMisconductLevelIntent::class)->name('misconduct-level.update-misconduct-level');
    Route::middleware(AuthGuard::class)->post('/delete-misconduct-level', DeleteMisconductLevelIntent::class)->name('misconduct-level.delete-misconduct-level');
    Route::middleware(AuthGuard::class)->post('/get-misconduct-level-list-data', GetMisconductLevelListDataIntent::class)->name('misconduct-level.get-misconduct-level-list-data');
});

// DisciplineRecord (one row per incident)
Route::prefix('discipline-record')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-discipline-record', CreateDisciplineRecordIntent::class)->name('discipline-record.create-discipline-record');
    Route::middleware(AuthGuard::class)->post('/update-discipline-record', UpdateDisciplineRecordIntent::class)->name('discipline-record.update-discipline-record');
    Route::middleware(AuthGuard::class)->post('/delete-discipline-record', DeleteDisciplineRecordIntent::class)->name('discipline-record.delete-discipline-record');
    Route::middleware(AuthGuard::class)->post('/approve-discipline-record', ApproveDisciplineRecordIntent::class)->name('discipline-record.approve-discipline-record');
    Route::middleware(AuthGuard::class)->post('/reject-discipline-record', RejectDisciplineRecordIntent::class)->name('discipline-record.reject-discipline-record');
    Route::middleware(AuthGuard::class)->post('/get-discipline-record-list-data', GetDisciplineRecordListDataIntent::class)->name('discipline-record.get-discipline-record-list-data');
    Route::middleware(AuthGuard::class)->post('/get-student-discipline-summary', GetStudentDisciplineSummaryIntent::class)->name('discipline-record.get-student-discipline-summary');
    Route::middleware(AuthGuard::class)->post('/get-discipline-grade-dashboard', GetDisciplineGradeDashboardIntent::class)->name('discipline-record.get-discipline-grade-dashboard');
});
