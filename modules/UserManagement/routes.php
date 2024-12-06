<?php

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Intents\User\GetUserListData\GetUserListDataIntent;


Route::post('/get-user-list-data', GetUserListDataIntent::class)->name('user.get-user-list-data');
