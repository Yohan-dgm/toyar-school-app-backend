<?php

use App\Http\Controllers\ActivityFeedMediaController;
use App\Http\Controllers\UserProfileImageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*//////////////////////////////////////////////////////////////////////////////
Root Blank Page
*/ /////////////////////////////////////////////////////////////////////////////
Route::get('/', function () {
    return view('welcome');
});
// ActivityFeedMedia url format = https://school-app.toyar.lk/get-activity-feed-media?url=/nexis-college/yakkala/activity-feed/media/video&filename=end_date.mp4&mime_type=video/mp4
Route::get('/get-activity-feed-media', [ActivityFeedMediaController::class, 'getActivityFeedMedia']);

// User Profile Image URL format = https://school-app.toyar.lk/get-user-profile-image?url=storage/temp-uploads/profile_images/user_43-1756401440.0394.png&filename=school-app-icon.png&mime_type=image%2Fpng
Route::get('/get-user-profile-image', [UserProfileImageController::class, 'getUserProfileImage']);
