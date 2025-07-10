<?php

use App\Middleware\AuthGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\ActivityFeedManagement\Intents\SchoolPost\CreateSchoolPost\CreateSchoolPostIntent;
use Modules\ActivityFeedManagement\Intents\SchoolPost\GetSchoolPosts\GetSchoolPostsIntent;
use Modules\ActivityFeedManagement\Intents\SchoolPost\UpdateSchoolPost\UpdateSchoolPostIntent;
use Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike\ToggleLikeIntent;

// School Posts - Activity Feed
Route::prefix('school-posts')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create', CreateSchoolPostIntent::class)->name('school-posts.create');
    Route::middleware(AuthGuard::class)->post('/list', GetSchoolPostsIntent::class)->name('school-posts.list');
    Route::middleware(AuthGuard::class)->post('/update', UpdateSchoolPostIntent::class)->name('school-posts.update');
    Route::middleware(AuthGuard::class)->post('/toggle-like', ToggleLikeIntent::class)->name('school-posts.toggle-like');
});


// POST /api/activity-feed-management/school-posts/create
// POST /api/activity-feed-management/school-posts/list
// POST /api/activity-feed-management/school-posts/update
// POST /api/activity-feed-management/school-posts/toggle-like

// Production endpoints are above - all routes use AuthGuard middleware
// and get user_id from $request->user()->id in the Intent files
