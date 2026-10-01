<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Intents\User\CreateUser\CreateUserIntent;
use Modules\UserManagement\Intents\User\GetUserListData\GetUserListDataIntent;
use Modules\UserManagement\Intents\User\GetMyStudentList\GetMyStudentListIntent;
use Modules\UserManagement\Intents\User\SignIn\SignInIntent;
use Modules\UserManagement\Intents\User\SignOut\SignOutIntent;
use Modules\UserManagement\Intents\UserProfile\ChangePassword\ChangePasswordIntent;
use Modules\UserManagement\Intents\UserProfile\UploadUserProfilePhoto\UploadUserProfilePhotoIntent;
use Modules\UserManagement\Intents\UserProfile\UploadUserProfilePhoto\UploadUserProfilePhotoDebugIntent;
use Modules\UserManagement\Intents\UserPayment\CreateUserPayment\CreateUserPaymentIntent;
use Modules\UserManagement\Intents\UserPayment\GetUserPayments\GetUserPaymentsIntent;
use Modules\UserManagement\Intents\UserPayment\GetCurrentUserPayments\GetCurrentUserPaymentsIntent;
use Modules\UserManagement\Intents\UserPayment\DebugUserPayments\DebugUserPaymentsIntent;
use App\Http\Controllers\UserProfileImageController;
use Modules\UserManagement\Intents\User\GetCurrentUserAppUpdateStatus\GetCurrentUserAppUpdateStatusIntent;
use Modules\UserManagement\Intents\UserPushToken\RegisterPushToken\RegisterPushTokenIntent;
use Modules\UserManagement\Intents\UserPushToken\DeletePushToken\DeletePushTokenIntent;

// User
Route::prefix('user')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-user', CreateUserIntent::class)->name('user.create-user');
    Route::middleware(AuthGuard::class)->post('/get-user-list-data', GetUserListDataIntent::class)->name('user.get-user-list-data');
    Route::middleware(AuthGuard::class)->post('/get-app-update-status', GetCurrentUserAppUpdateStatusIntent::class)->name('user.get-app-update-status');
    Route::middleware(AuthGuard::class)->post('/get-my-student-list', GetMyStudentListIntent::class)->name('user.get-my-student-list');
    Route::middleware('api')->post('/sign-in', SignInIntent::class)->name('user.sign-in');
    Route::middleware('api')->get('/sign-out', SignOutIntent::class)->name('user.sign-out');
});

// User Profile
Route::prefix('user-profile')->group(function () {
    Route::middleware(AuthGuard::class)->post('/change-password', ChangePasswordIntent::class)->name('user-profile.change-password');
    Route::middleware(AuthGuard::class)->post('/upload-profile-photo', UploadUserProfilePhotoIntent::class)->name('user-profile.upload-profile-photo');
    
    // DEBUG: Upload without authentication (development only)
    Route::post('/debug-upload-profile-photo', UploadUserProfilePhotoDebugIntent::class)->name('user-profile.debug-upload-profile-photo');
});

// User Payments
Route::prefix('user-payment')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-user-payment', CreateUserPaymentIntent::class)->name('user-payment.create-user-payment');
    Route::middleware(AuthGuard::class)->post('/get-user-payments', GetUserPaymentsIntent::class)->name('user-payment.get-user-payments');
    Route::middleware(AuthGuard::class)->post('/current', GetCurrentUserPaymentsIntent::class)->name('user-payment.get-current-user-payments');
    Route::middleware(AuthGuard::class)->post('/debug-user-payments', DebugUserPaymentsIntent::class)->name('user-payment.debug-user-payments');
});

// User Profile Images
Route::prefix('user-profile-image')->group(function () {
    Route::middleware(AuthGuard::class)->get('/', [UserProfileImageController::class, 'index'])->name('user-profile-image.index');
    Route::middleware(AuthGuard::class)->get('/active', [UserProfileImageController::class, 'getActive'])->name('user-profile-image.active');
    Route::middleware(AuthGuard::class)->get('/{id}', [UserProfileImageController::class, 'show'])->name('user-profile-image.show');
    Route::middleware(AuthGuard::class)->delete('/{id}', [UserProfileImageController::class, 'destroy'])->name('user-profile-image.destroy');
    Route::middleware(AuthGuard::class)->patch('/{id}/activate', [UserProfileImageController::class, 'activate'])->name('user-profile-image.activate');
    Route::middleware(AuthGuard::class)->patch('/{id}/deactivate', [UserProfileImageController::class, 'deactivate'])->name('user-profile-image.deactivate');
});

// Push Token Management Routes - All routes require authentication
Route::prefix('push-tokens')->middleware(AuthGuard::class)->group(function () {

    // Register or update push token
    // POST /api/user-management/push-tokens/register
    Route::post('/register', RegisterPushTokenIntent::class)
        ->name('push-tokens.register');

    // Delete push tokens (by device_id, push_token, or all user tokens)
    // POST /api/user-management/push-tokens/delete
    Route::post('/delete', DeletePushTokenIntent::class)
        ->name('push-tokens.delete');
});

// API Endpoint Documentation:
//
// 1. Register Push Token
//    POST /api/user-management/push-tokens/register
//    Body: {
//        "device_id": "unique-device-identifier",
//        "push_token": "ExponentPushToken[xxxxxxxxxxxxxxxxxxxxx]",
//        "platform": "ios|android",
//        "app_version": "1.2.3",                    // optional
//        "device_name": "John's iPhone",           // optional
//        "device_model": "iPhone 14 Pro",         // optional
//        "os_version": "17.1.1"                   // optional
//    }
//
// 2. Delete Push Token
//    POST /api/user-management/push-tokens/delete
//    Body: {
//        "device_id": "unique-device-identifier", // optional
//        "push_token": "ExponentPushToken[xxx]",  // optional
//        // Note: If both device_id and push_token are omitted, all user tokens are deleted
//        // If only device_id is provided, all tokens for that device are deleted
//        // If only push_token is provided, that specific token is deleted
//        // If both are provided, tokens matching both criteria are deleted
//    }
//
// All endpoints return JSON responses with the following structure:
// Success: { "success": true, "message": "...", "data": {...} }
// Error: { "success": false, "message": "...", "errors": {...} }

