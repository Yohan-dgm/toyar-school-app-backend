<?php

use App\Http\Controllers\MediaController;
use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
// SchoolPost Intents
use Modules\ActivityFeedManagement\Intents\SchoolPost\CreateSchoolPost\CreateSchoolPostIntent;
use Modules\ActivityFeedManagement\Intents\SchoolPost\DeleteSchoolPost\DeleteSchoolPostIntent;
use Modules\ActivityFeedManagement\Intents\SchoolPost\GetSchoolPosts\GetSchoolPostsIntent;
use Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike\ToggleLikeIntent;
use Modules\ActivityFeedManagement\Intents\SchoolPost\UpdateSchoolPost\UpdateSchoolPostIntent;
// ClassPost Intents
use Modules\ActivityFeedManagement\Intents\ClassPost\CreateClassPost\CreateClassPostIntent;
use Modules\ActivityFeedManagement\Intents\ClassPost\DeleteClassPost\DeleteClassPostIntent;
use Modules\ActivityFeedManagement\Intents\ClassPost\GetClassPosts\GetClassPostsIntent;
use Modules\ActivityFeedManagement\Intents\ClassPost\ToggleLike\ToggleLikeIntent as ClassPostToggleLikeIntent;
use Modules\ActivityFeedManagement\Intents\ClassPost\UpdateClassPost\UpdateClassPostIntent;
// ClassPost Comment Intents
use Modules\ActivityFeedManagement\Intents\ClassPost\CreateClassPostComment\CreateClassPostCommentIntent;
use Modules\ActivityFeedManagement\Intents\ClassPost\DeleteClassPostComment\DeleteClassPostCommentIntent;
use Modules\ActivityFeedManagement\Intents\ClassPost\GetClassPostComments\GetClassPostCommentsIntent;
// StudentPost Intents
use Modules\ActivityFeedManagement\Intents\StudentPost\CreateStudentPost\CreateStudentPostIntent;
use Modules\ActivityFeedManagement\Intents\StudentPost\DeleteStudentPost\DeleteStudentPostIntent;
use Modules\ActivityFeedManagement\Intents\StudentPost\GetStudentPosts\GetStudentPostsIntent;
use Modules\ActivityFeedManagement\Intents\StudentPost\ToggleLike\ToggleLikeIntent as StudentPostToggleLikeIntent;
use Modules\ActivityFeedManagement\Intents\StudentPost\UpdateStudentPost\UpdateStudentPostIntent;
// Media Intents
use Modules\ActivityFeedManagement\Intents\Media\ChunkedUpload\FinishChunkedUploadIntent;
use Modules\ActivityFeedManagement\Intents\Media\ChunkedUpload\InitChunkedUploadIntent;
use Modules\ActivityFeedManagement\Intents\Media\ChunkedUpload\PushUploadChunkIntent;
use Modules\ActivityFeedManagement\Intents\Media\UploadMedia\UploadMediaIntent;

// School Posts - Updated endpoints with full CRUD
Route::prefix('school-posts')->middleware(AuthGuard::class)->group(function () {
    Route::post('/create', CreateSchoolPostIntent::class)->name('school-posts.create');
    Route::post('/list', GetSchoolPostsIntent::class)->name('school-posts.list');
    Route::post('/update', UpdateSchoolPostIntent::class)->name('school-posts.update');
    Route::post('/delete', DeleteSchoolPostIntent::class)->name('school-posts.delete');
    Route::post('/toggle-like', ToggleLikeIntent::class)->name('school-posts.toggle-like');
});

// Class Posts - New endpoints with full CRUD
Route::prefix('class-posts')->middleware(AuthGuard::class)->group(function () {
    Route::post('/create', CreateClassPostIntent::class)->name('class-posts.create');
    Route::post('/list', GetClassPostsIntent::class)->name('class-posts.list');
    Route::post('/update', UpdateClassPostIntent::class)->name('class-posts.update');
    Route::post('/delete', DeleteClassPostIntent::class)->name('class-posts.delete');
    Route::post('/toggle-like', ClassPostToggleLikeIntent::class)->name('class-posts.toggle-like');
});

// Student Posts - New endpoints with full CRUD
Route::prefix('student-posts')->middleware(AuthGuard::class)->group(function () {
    Route::post('/create', CreateStudentPostIntent::class)->name('student-posts.create');
    Route::post('/list', GetStudentPostsIntent::class)->name('student-posts.list');
    Route::post('/update', UpdateStudentPostIntent::class)->name('student-posts.update');
    Route::post('/delete', DeleteStudentPostIntent::class)->name('student-posts.delete');
    Route::post('/toggle-like', StudentPostToggleLikeIntent::class)->name('student-posts.toggle-like');
});

// Media Upload - New endpoint for standalone file uploads
Route::prefix('media')->middleware(AuthGuard::class)->group(function () {
    Route::post('/upload', UploadMediaIntent::class)->name('media.upload');
    
    // Chunked Media Upload
    Route::prefix('chunked')->group(function () {
        Route::post('/init', InitChunkedUploadIntent::class)->name('media.chunked.init');
        Route::post('/push', PushUploadChunkIntent::class)->name('media.chunked.push');
        Route::post('/finish', FinishChunkedUploadIntent::class)->name('media.chunked.finish');
    });
});

// School Posts API Endpoints:
// POST /api/activity-feed-management/school-posts/create
// POST /api/activity-feed-management/school-posts/list
// POST /api/activity-feed-management/school-posts/update
// POST /api/activity-feed-management/school-posts/delete
// POST /api/activity-feed-management/school-posts/toggle-like

// Class Posts API Endpoints:
// POST /api/activity-feed-management/class-posts/create
// POST /api/activity-feed-management/class-posts/list
// POST /api/activity-feed-management/class-posts/update
// POST /api/activity-feed-management/class-posts/delete
// POST /api/activity-feed-management/class-posts/toggle-like

// Student Posts API Endpoints:
// POST /api/activity-feed-management/student-posts/create
// POST /api/activity-feed-management/student-posts/list
// POST /api/activity-feed-management/student-posts/update
// POST /api/activity-feed-management/student-posts/delete
// POST /api/activity-feed-management/student-posts/toggle-like

// Media Upload API Endpoints:
// POST /api/activity-feed-management/media/upload

// Storage Routes - Serve authenticated files from storage/app
Route::prefix('storage')->middleware(AuthGuard::class)->group(function () {
    // List directory: /api/activity-feed-management/storage/list/{directory?}
    Route::get('/list/{directory?}', [MediaController::class, 'listDirectory'])
        ->where('directory', '.*')
        ->name('activity-feed.storage.list');

    // Serve files: /api/activity-feed-management/storage/file/{path}
    Route::get('/file/{path}', [MediaController::class, 'show'])
        ->where('path', '.*')
        ->name('activity-feed.storage.show');

    // Get file info: /api/activity-feed-management/storage/info/{path}
    Route::get('/info/{path}', [MediaController::class, 'info'])
        ->where('path', '.*')
        ->name('activity-feed.storage.info');
});

// Class Post Comments - New endpoints
Route::prefix('class-posts')->middleware(AuthGuard::class)->group(function () {
    Route::post('/comments/list', GetClassPostCommentsIntent::class)->name('class-posts.comments.list');
    Route::post('/comments/create', CreateClassPostCommentIntent::class)->name('class-posts.comments.create');
    Route::post('/comments/delete', DeleteClassPostCommentIntent::class)->name('class-posts.comments.delete');
});

// Class Post Comments API Endpoints:
// POST /api/activity-feed-management/class-posts/comments/list
// POST /api/activity-feed-management/class-posts/comments/create
// POST /api/activity-feed-management/class-posts/comments/delete

// Production endpoints are above - all routes use AuthGuard middleware
// and get user_id from $request->user()->id in the Intent files
