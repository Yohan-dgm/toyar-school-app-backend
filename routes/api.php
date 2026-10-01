<?php

use App\Http\Controllers\MediaController;
use App\Middleware\AuthGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/', function (Request $request) {
    return 'SCHOOL APP API';
});

// Authenticated Storage Routes - Access all files in storage/app
Route::prefix('storage')->middleware(AuthGuard::class)->group(function () {
    // List directory contents: /api/storage/list/{directory?}
    // Example: /api/storage/list or /api/storage/list/nexis-college
    Route::get('/list/{directory?}', [MediaController::class, 'listDirectory'])
        ->where('directory', '.*')
        ->name('storage.list');

    // Serve files by full path: /api/storage/file/{path}
    // Example: /api/storage/file/nexis-college/yakkala/activity-feed/media/image/photo.jpg
    Route::get('/file/{path}', [MediaController::class, 'show'])
        ->where('path', '.*')
        ->name('storage.show');

    // Alternative route with directory separation: /api/storage/dir/{directory}/{filename}
    // Example: /api/storage/dir/nexis-college/document.pdf
    Route::get('/dir/{directory}/{filename}', [MediaController::class, 'showByDirectory'])
        ->where('directory', '[^/]+')
        ->where('filename', '.*')
        ->name('storage.show-by-directory');

    // Get file info without downloading: /api/storage/info/{path}
    Route::get('/info/{path}', [MediaController::class, 'info'])
        ->where('path', '.*')
        ->name('storage.info');
});
require __DIR__.'/../modules/EducatorFeedbackManagement/routes/api.php';

// Communication Management Routes
Route::prefix('communication-management')->group(function () {
    require __DIR__.'/../modules/CommunicationManagement/routes.php';
});
