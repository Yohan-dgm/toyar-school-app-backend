<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\EducatorManagement\Intents\Educator\CreateEducator\CreateEducatorIntent;
use Modules\EducatorManagement\Intents\Educator\GetEducatorListData\GetEducatorListDataIntent;
use Modules\EducatorManagement\Intents\Educator\GetEducatorClassStudents\GetEducatorClassStudentsIntent;
use Modules\EducatorManagement\Intents\Educator\UpdateEducator\UpdateEducatorIntent;
use Modules\EducatorManagement\Intents\EducatorGrade\GetEducatorGradeListData\GetEducatorGradeListDataIntent;

// Program
// Route::prefix('educator')->group(function () {
//     Route::middleware('auth:web')->post('/get-educator-list-data', GetEducatorListDataIntent::class)->name('educator.get-educator-list-data');
//     Route::middleware('auth:web')->post('/create-educator', CreateEducatorIntent::class)->name('educator.create-educator');
//     Route::middleware('auth:web')->post('/update-educator', UpdateEducatorIntent::class)->name('educator.update-educator');
// });
// // Educator Grade
// Route::prefix('educator-grade')->group(function () {
//     Route::middleware('auth:web')->post('/get-educator-grade-list-data', GetEducatorGradeListDataIntent::class)->name('educator-grade.get-educator-grade-list-data');
// });

Route::prefix('educator')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-educator-list-data', GetEducatorListDataIntent::class)->name('educator.get-educator-list-data');
    Route::middleware(AuthGuard::class)->post('/get-educator-class-students', GetEducatorClassStudentsIntent::class)->name('educator.get-educator-class-students');
});
