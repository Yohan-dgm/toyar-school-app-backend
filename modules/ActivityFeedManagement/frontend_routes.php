<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike\ToggleLikeIntent;

// Frontend-expected routes for React Native app
// These routes match the frontend's expected URL structure

// POST /api/activity-feed/post/like
Route::prefix('post')->group(function () {
    Route::middleware(AuthGuard::class)->post('/like', ToggleLikeIntent::class)->name('activity-feed.post.like');
});
