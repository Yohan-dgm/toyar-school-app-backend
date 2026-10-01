<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\StudentManagement\Intents\Student\GetStudentById\GetStudentByIdIntent;
use Modules\StudentManagement\Intents\Student\GetStudentDetailsByClass\GetStudentDetailsByClassIntent;
use Modules\StudentManagement\Intents\Student\GetStudentHeaderData\GetStudentHeaderDataIntent;
use Modules\StudentManagement\Intents\Student\GetStudentListData\GetStudentListDataIntent;
use Modules\StudentManagement\Intents\Student\GetStudentsByClass\GetStudentsByClassIntent;
use Modules\StudentManagement\Intents\StudentAchievement\CreateStudentAchievement\CreateStudentAchievementIntent;
use Modules\StudentManagement\Intents\StudentAchievement\GetCurrentStudentAchievements\GetCurrentStudentAchievementsIntent;
use Modules\StudentManagement\Intents\StudentAchievement\GetStudentAchievements\GetStudentAchievementsIntent;
use Modules\StudentManagement\Intents\StudentAttachment\GetStudentAttachmentList\GetStudentAttachmentListIntent;

use Modules\StudentManagement\Intents\StudentInsights\GetStudentInsightsListData\GetStudentInsightsListDataIntent;

// student
// Route::prefix('student')->group(function () {
//     Route::middleware('auth:web')->post('/get-student-list-data', GetStudentListDataIntent::class)->name('student.get-student-list-data');
//     Route::middleware('auth:web')->post('/create-student', CreateStudentIntent::class)->name('student.create-student');
//     Route::middleware('auth:web')->post('/update-student', UpdateStudentIntent::class)->name('student.update-student');
//     Route::middleware(AuthGuard::class)->post('/get-student-list-data', [CalendarManagementController::class, 'getSpecialClassListData'])->name('special-class.get-special-class-list-data');
// });

Route::prefix('student')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-student-list-data', GetStudentListDataIntent::class)->name('student.get-student-list-data');
    Route::middleware(AuthGuard::class)->post('/get-student-by-id', GetStudentByIdIntent::class)->name('student.get-student-by-id');
    Route::middleware(AuthGuard::class)->post('/get-student-header-data', GetStudentHeaderDataIntent::class)->name('student.get-student-header-data');
    // Route::middleware(AuthGuard::class)->post('/get-students-by-class', GetStudentsByClassIntent::class)->name('student.get-students-by-class');
    Route::middleware(AuthGuard::class)->post('/get-student-details-by-class', GetStudentDetailsByClassIntent::class)->name('student.get-student-details-by-class');
});

// Route::middleware(AuthGuard::class)->post('/get-special-class-list-data', [CalendarManagementController::class, 'getSpecialClassListData'])->name('special-class.get-special-class-list-data');

// school-house
// Route::prefix('school-house')->group(function () {
//     Route::middleware('auth:web')->post('/get-school-house-list-data', GetSchoolHouseListDataIntent::class)->name('school-house.get-school-house-list-data');
// });
// // student-admission-source
// Route::prefix('student-admission-source')->group(function () {
//     Route::middleware('auth:web')->post('/get-student-admission-source-list-data', GetStudentAdmissionSourceListDataIntent::class)->name('student-admission-source.get-student-admission-source-list-data');
// });

// student-supply
// Route::prefix('student-supply')->group(function () {
//     Route::middleware('auth:web')->post('/create-student-supply', CreateStudentSupplyIntent::class)->name('student-supply.create-student-supply');
//     Route::middleware('auth:web')->post('/get-student-supply-list-data', GetStudentSupplyListDataIntent::class)->name('student-supply.get-student-supply-list-data');
//     Route::middleware('auth:web')->post('/update-student-supply', UpdateStudentSupplyIntent::class)->name('student-supply.update-student-supply');
// });

// // student-supply-note
// Route::prefix('student-supply-note')->group(function () {
//     Route::middleware('auth:web')->post('/get-student-supply-note-list-data', GetStudentSupplyNoteListDataIntent::class)->name('student-supply-note.get-student-supply-note-list-data');
//     Route::middleware('auth:web')->post('/create-student-supply-note', CreateStudentSupplyNoteIntent::class)->name('student-supply-note.create-student-supply-note');
//     Route::middleware('auth:web')->post('/update-student-supply-note', UpdateStudentSupplyNoteIntent::class)->name('student-supply-note.update-student-supply-note');
// });

// // student-supply-note-status
// Route::prefix('student-supply-note-status')->group(function () {
//     Route::middleware('auth:web')->post('/create-student-supply-note-status', CreateStudentSupplyNoteStatusIntent::class)->name('student-supply-note-status.create-student-supply-note-status');
// });

// visibility-type
// Route::prefix('visibility-type')->group(function () {
//     Route::middleware('auth:web')->post('/get-visibility-type-list-data', GetVisibilityTypeListDataIntent::class)->name('visibility-type.get-visibility-type-list-data');
// });
// Route::prefix('educator-feedback-evolution')->group(function () {
//     Route::middleware('auth:web')->post('/get-educator-feedback-evolution-list-data', GetEducatorFeedbackEvolutionListDataIntent::class)->name('educator-feedback-evolution.get-educator-feedback-evolution-list-data');
// });

// // student-sport
// Route::prefix('student-sport')->group(function () {
//     Route::middleware('auth:web')->post('/get-student-sport-list-data', GetStudentSportListDataIntent::class)->name('student-sport.get-student-sport-list-data');
//     Route::middleware('auth:web')->post('/create-student-sport', CreateStudentSportIntent::class)->name('student-sport.create-student-sport');
//     Route::middleware('auth:web')->post('/update-student-sport', UpdateStudentSportIntent::class)->name('student-sport.update-student-sport');
// });

// student-achievement
Route::prefix('student-achievement')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create', CreateStudentAchievementIntent::class)->name('student-achievement.create');
    Route::middleware(AuthGuard::class)->post('/get-list-data', GetStudentAchievementsIntent::class)->name('student-achievement.get-list-data');
    Route::middleware(AuthGuard::class)->post('/get-current-by-student-id', GetCurrentStudentAchievementsIntent::class)->name('student-achievement.get-current-by-student-id');
});

// student-attachment
Route::prefix('student-attachment')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-list-by-student-id', GetStudentAttachmentListIntent::class)->name('student-attachment.get-list-by-student-id');
});


Route::prefix('student-insights')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-student-insights-list-data', GetStudentInsightsListDataIntent::class)->name('student-insights.get-student-insights-list-data');
});