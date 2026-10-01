<?php

use Illuminate\Support\Facades\Route;
use Modules\AdmissionManagement\Intents\Applicant\CreateApplicant\CreateApplicantIntent;
use Modules\AdmissionManagement\Intents\Applicant\GetApplicantListData\GetApplicantListDataIntent;
use Modules\AdmissionManagement\Intents\Applicant\UpdateApplicant\UpdateApplicantIntent;

// applicant
Route::prefix('applicant')->group(function () {
    Route::middleware('auth:web')->post('/get-applicant-list-data', GetApplicantListDataIntent::class)->name('applicant.get-applicant-list-data');
    Route::middleware('auth:web')->post('/create-applicant', CreateApplicantIntent::class)->name('applicant.create-applicant');
    Route::middleware('auth:web')->post('/update-applicant', UpdateApplicantIntent::class)->name('applicant.update-applicant');
});
