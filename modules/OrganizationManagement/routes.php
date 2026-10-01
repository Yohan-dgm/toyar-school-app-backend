<?php

use Illuminate\Support\Facades\Route;
use Modules\OrganizationManagement\Intents\OrganizationManagement\AttachSchoolDateAttributeToSchoolDate\AttachSchoolDateAttributeToSchoolDateIntent;
use Modules\OrganizationManagement\Intents\OrganizationManagement\DetachSchoolDateAttributeListFromSchoolDate\DetachSchoolDateAttributeListFromSchoolDateIntent;
use Modules\OrganizationManagement\Intents\OrganizationManagement\GetSchoolDateListData\GetSchoolDateListDataIntent;

// organization-management
Route::prefix('organization-management')->group(function () {
    Route::middleware('auth:web')->post('/attach-school-date-attribute-to-school-date', AttachSchoolDateAttributeToSchoolDateIntent::class)->name('organization-management.attach-school-date-attribute-to-school-date');
    Route::middleware('auth:web')->post('/detach-school-date-attribute-list-form-school-date', DetachSchoolDateAttributeListFromSchoolDateIntent::class)->name('organization-management.detach-school-date-attribute-list-form-school-date');
    Route::middleware('auth:web')->post('/get-school-date-list-data', GetSchoolDateListDataIntent::class)->name('organization-management.get-school-date-list-data');
});
