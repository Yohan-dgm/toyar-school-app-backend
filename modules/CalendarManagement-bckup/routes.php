<?php

use App\Http\Controllers\CalendarManagementController;
use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;

// event - Traditional Laravel Controller Routes
Route::prefix('event')->group(function () {
    // TODO: Implement these methods in CalendarManagementController
    // Route::middleware('auth:web')->post('/create-event', [CalendarManagementController::class, 'createEvent'])->name('event.create-event');
    // Route::middleware('auth:web')->post('/update-event', [CalendarManagementController::class, 'updateEvent'])->name('event.update-event');
    Route::middleware(AuthGuard::class)->post('/get-event-list-data', [CalendarManagementController::class, 'getEventListData'])->name('event.get-event-list-data');
    // Route::middleware('auth:web')->post('/approval-event', [CalendarManagementController::class, 'approvalEvent'])->name('event.approval-event');
});
// Route::middleware(AuthGuard::class)->post('/list', GetSchoolPostsIntent::class)->name('school-posts.list');

// Route::prefix('school-posts')->group(function () {
//     Route::middleware(AuthGuard::class)->post('/create', CreateSchoolPostIntent::class)->name('school-posts.create');
//     Route::middleware(AuthGuard::class)->post('/list', GetSchoolPostsIntent::class)->name('school-posts.list');
//     Route::middleware(AuthGuard::class)->post('/update', UpdateSchoolPostIntent::class)->name('school-posts.update');
//     Route::middleware(AuthGuard::class)->post('/toggle-like', ToggleLikeIntent::class)->name('school-posts.toggle-like');
// });

// TODO: Convert these to traditional controller methods when needed
// event-category
// Route::prefix('event-category')->group(function () {
//     Route::middleware('auth:web')->post('/create-event-category', [CalendarManagementController::class, 'createEventCategory'])->name('event-category.create-event-category');
//     Route::middleware('auth:web')->post('/update-event-category', [CalendarManagementController::class, 'updateEventCategory'])->name('event-category.update-event-category');
//     Route::middleware('auth:web')->post('/get-event-category-list-data', [CalendarManagementController::class, 'getEventCategoryListData'])->name('event-category.get-event-category-list-data');
// });

// holiday - Traditional Laravel Controller Routes
Route::prefix('holiday')->group(function () {
    // TODO: Implement these methods in CalendarManagementController
    // Route::middleware(AuthGuard::class)->post('/create-holiday', [CalendarManagementController::class, 'createHoliday'])->name('holiday.create-holiday');
    // Route::middleware(AuthGuard::class)->post('/update-holiday', [CalendarManagementController::class, 'updateHoliday'])->name('holiday.update-holiday');
    Route::middleware(AuthGuard::class)->post('/get-holiday-list-data', [CalendarManagementController::class, 'getHolidayListData'])->name('holiday.get-holiday-list-data');
});

// calendar-dashboard
// Route::prefix('calendar-dashboard')->group(function () {
//     Route::middleware('auth:web')->post('/get-calendar-dashboard-list-data', [CalendarManagementController::class, 'getCalendarDashboardListData'])->name('calendar-dashboard.get-calendar-dashboard-list-data');
// });

// special-class - Traditional Laravel Controller Routes
Route::prefix('special-class')->group(function () {
    // TODO: Implement these methods in CalendarManagementController
    // Route::middleware(AuthGuard::class)->post('/create-special-class', [CalendarManagementController::class, 'createSpecialClass'])->name('special-class.create-special-class');
    // Route::middleware(AuthGuard::class)->post('/update-special-class', [CalendarManagementController::class, 'updateSpecialClass'])->name('special-class.update-special-class');
    Route::middleware(AuthGuard::class)->post('/get-special-class-list-data', [CalendarManagementController::class, 'getSpecialClassListData'])->name('special-class.get-special-class-list-data');
});
