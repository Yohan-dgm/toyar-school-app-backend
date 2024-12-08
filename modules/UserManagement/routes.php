<?php

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Intents\User\CreateUser\CreateUserIntent;
use Modules\UserManagement\Intents\User\GetUserListData\GetUserListDataIntent;
use Modules\UserManagement\Intents\User\SignIn\SignInIntent;
use Modules\UserManagement\Intents\User\SignOut\SignOutIntent;

// User
Route::prefix('user')->group(function () {
    Route::middleware('auth:web')->post('/create-user', CreateUserIntent::class)->name('user.create-user');
    Route::middleware('auth:web')->post('/get-user-list-data', GetUserListDataIntent::class)->name('user.get-user-list-data');
    Route::middleware('web')->post('/sign-in', SignInIntent::class)->name('user.sign-in');
    Route::middleware('web')->post('/sign-out', SignOutIntent::class)->name('user.sign-out');
});