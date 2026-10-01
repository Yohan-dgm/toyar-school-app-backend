<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\EmployeeManagement\Intents\Designation\GetDesignationListData\GetDesignationListDataIntent;
use Modules\EmployeeManagement\Intents\Employee\CreateEmployee\CreateEmployeeIntent;
use Modules\EmployeeManagement\Intents\Employee\GetEmployeeListData\GetEmployeeListDataIntent;
use Modules\EmployeeManagement\Intents\EmployeeType\GetEmployeeTypeListData\GetEmployeeTypeListDataIntent;

// // employee
// Route::prefix('employee')->group(function () {
//     Route::middleware('auth:web')->post('/create-employee', CreateEmployeeIntent::class)->name('employee.create-employee');
//     Route::middleware('auth:web')->post('/get-employee-list-data', GetEmployeeListDataIntent::class)->name('employee.get-employee-list-data');
// });
// // employee-type
// Route::prefix('employee-type')->group(function () {
//     Route::middleware('auth:web')->post('/get-employee-type-list-data', GetEmployeeTypeListDataIntent::class)->name('employee-type.get-employee-type-list-data');
// });
// // designation
// Route::prefix('designation')->group(function () {
//     Route::middleware('auth:web')->post('/get-designation-list-data', GetDesignationListDataIntent::class)->name('designation.get-designation-list-data');
// });

Route::prefix('employee')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-employee-list-data', GetEmployeeListDataIntent::class)->name('employee.get-employee-list-data');
});
