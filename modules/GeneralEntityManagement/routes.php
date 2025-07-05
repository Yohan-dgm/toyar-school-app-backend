<?php

namespace Modules\GeneralEntityManagement;

use Illuminate\Support\Facades\Route;
use Modules\GeneralEntityManagement\Intents\Bank\GetBankListData\GetBankListDataIntent;
use Modules\GeneralEntityManagement\Intents\Country\GetCountryListData\GetCountryListDataIntent;
use Modules\GeneralEntityManagement\Intents\Nationality\GetNationalityListData\GetNationalityListDataIntent;
use Modules\GeneralEntityManagement\Intents\PersonTitle\GetPersonTitleListData\GetPersonTitleListDataIntent;
use Modules\GeneralEntityManagement\Intents\Religion\GetReligionListData\GetReligionListDataIntent;
use Modules\GeneralEntityManagement\Intents\Unit\GetUnitListData\GetUnitListDataIntent;

// bank
Route::prefix('bank')->group(function () {
    Route::middleware('auth:web')->post('/get-bank-list-data', GetBankListDataIntent::class)->name('bank.get-bank-list-data');
});
// unit
Route::prefix('unit')->group(function () {
    Route::middleware('auth:web')->post('/get-unit-list-data', GetUnitListDataIntent::class)->name('unit.get-unit-list-data');
});
// country
Route::prefix('country')->group(function () {
    Route::middleware('auth:web')->post('/get-country-list-data', GetCountryListDataIntent::class)->name('country.get-country-list-data');
});

// religion
Route::prefix('religion')->group(function () {
    Route::middleware('auth:web')->post('/get-religion-list-data', GetReligionListDataIntent::class)->name('religion.get-religion-list-data');
});

// nationality
Route::prefix('nationality')->group(function () {
    Route::middleware('auth:web')->post('/get-nationality-list-data', GetNationalityListDataIntent::class)->name('nationality.get-nationality-list-data');
});

// person-title
Route::prefix('person-title')->group(function () {
    Route::middleware('auth:web')->post('/get-person-title-list-data', GetPersonTitleListDataIntent::class)->name('person-title.get-person-title-list-data');
});
