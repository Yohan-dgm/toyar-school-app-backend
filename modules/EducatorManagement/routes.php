<?php

use Illuminate\Support\Facades\Route;
use Modules\EducatorManagement\Intents\Educator\GetEducatorListData\GetEducatorListDataIntent;

// Program
Route::prefix('educator')->group(function () {
    Route::middleware('auth:web')->post('/get-educator-list-data', GetEducatorListDataIntent::class)->name('educator.get-educator-list-data');
});
