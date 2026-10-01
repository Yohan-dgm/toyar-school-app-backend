<?php

namespace Modules\SystemEntityManagement;

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\SystemEntityManagement\Intents\GradeLevelClass\GetGradeLevelClassListData\GetGradeLevelClassListDataIntent;

// use Modules\SystemEntityManagement\Intents\Term\GetTermListData\GetTermListDataIntent;

// term
// Route::prefix('term')->group(function () {
//     Route::middleware('auth:web')->post('/get-term-list-data', GetTermListDataIntent::class)->name('term.get-term-list-data');
// });

// grade-level-class
// Route::prefix('grade-level-class')->group(function () {
//     Route::middleware('auth:web')->post('/get-grade-level-class-list-data', GetGradeLevelClassListDataIntent::class)->name('grade-level-class.get-grade-level-class-list-data');
// });

Route::prefix('grade-level-class')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-grade-level-class-list-data', Getgrade - level - classListDataIntent::class)->name('grade-level-class.get-grade-level-class-list-data');
});
