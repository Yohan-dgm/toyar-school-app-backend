<?php

namespace Modules\UserManagement;

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Intents\User\CreateUser\CreateUserIntent;
use Modules\UserManagement\Intents\User\GetUserList\GetUserListIntent;
use Modules\UserManagement\Intents\User\SignInUser\SignInUserIntent;
use Modules\UserManagement\Intents\User\SignOutUser\SignOutUserIntent;

Route::prefix('user')->group(function () {
    Route::middleware('auth:web')->get('/', GetUserListIntent::class)->name('user.index');
    Route::middleware('auth:web')->post('/create', CreateUserIntent::class)->name('user.create');
    Route::middleware('web')->post('/sign-in', SignInUserIntent::class)->name('user.sign-in');
    Route::middleware('web')->get('/sign-out', SignOutUserIntent::class)->name('user.sign-out');
});
