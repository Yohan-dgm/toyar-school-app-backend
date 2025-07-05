<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Intents\User\CreateUser\CreateUserIntent;
use Modules\UserManagement\Intents\User\GetUserListData\GetUserListDataIntent;
use Modules\UserManagement\Intents\User\SignIn\SignInIntent;
use Modules\UserManagement\Intents\User\SignOut\SignOutIntent;
use Modules\UserManagement\Intents\UserProfile\ChangePassword\ChangePasswordIntent;

// User
Route::prefix('user')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-user', CreateUserIntent::class)->name('user.create-user');
    Route::middleware(AuthGuard::class)->post('/get-user-list-data', GetUserListDataIntent::class)->name('user.get-user-list-data');
    Route::middleware('api')->post('/sign-in', SignInIntent::class)->name('user.sign-in');
    Route::middleware('api')->get('/sign-out', SignOutIntent::class)->name('user.sign-out');
});
Route::prefix('user-profile')->group(function () {
    Route::middleware(AuthGuard::class)->post('/change-password', ChangePasswordIntent::class)->name('user-profile.change-password');
});
