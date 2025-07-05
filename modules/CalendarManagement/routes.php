<?php

use Illuminate\Support\Facades\Route;
use Modules\CalendarManagement\Intents\CalendarDashboard\GetCalendarDashboardListData\GetCalendarDashboardListDataIntent;
use Modules\CalendarManagement\Intents\Event\ApprovalEvent\ApprovalEventIntent;
use Modules\CalendarManagement\Intents\Event\GetEventListData\GetEventListDataIntent;
use Modules\CalendarManagement\Intents\EventCategory\GetEventCategoryListData\GetEventCategoryListDataIntent;
use Modules\CalendarManagement\Intents\Event\CreateEvent\CreateEventIntent;
use Modules\CalendarManagement\Intents\Event\UpdateEvent\UpdateEventIntent;
use Modules\CalendarManagement\Intents\EventCategory\CreateEventCategory\CreateEventCategoryIntent;
use Modules\CalendarManagement\Intents\EventCategory\UpdateEventCategory\UpdateEventCategoryIntent;
use Modules\CalendarManagement\Intents\Holiday\CreateHoliday\CreateHolidayIntent;
use Modules\CalendarManagement\Intents\Holiday\GetHolidayListData\GetHolidayListDataIntent;
use Modules\CalendarManagement\Intents\Holiday\UpdateHoliday\UpdateHolidayIntent;
use Modules\CalendarManagement\Intents\SpecialClass\CreateSpecialClass\CreateSpecialClassIntent;
use Modules\CalendarManagement\Intents\SpecialClass\GetSpecialClassListData\GetSpecialClassListDataIntent;
use Modules\CalendarManagement\Intents\SpecialClass\UpdateSpecialClass\UpdateSpecialClassIntent;

// event
Route::prefix('event')->group(function () {
    Route::middleware('auth:web')->post('/create-event', CreateEventIntent::class)->name('event.create-event');
    Route::middleware('auth:web')->post('/update-event', UpdateEventIntent::class)->name('event.update-event');
    Route::middleware('auth:web')->post('/get-event-list-data', GetEventListDataIntent::class)->name('event.get-event-list-data');
    Route::middleware('auth:web')->post('/approval-event', ApprovalEventIntent::class)->name('event.approval-event');
});

// event-category
Route::prefix('event-category')->group(function () {
    Route::middleware('auth:web')->post('/create-event-category', CreateEventCategoryIntent::class)->name('event-category.create-event-category');
    Route::middleware('auth:web')->post('/update-event-category', UpdateEventCategoryIntent::class)->name('event-category.update-event-category');
    Route::middleware('auth:web')->post('/get-event-category-list-data', GetEventCategoryListDataIntent::class)->name('event-category.get-event-category-list-data');
});

// holiday
Route::prefix('holiday')->group(function () {
    Route::middleware('auth:web')->post('/create-holiday', CreateHolidayIntent::class)->name('holiday.create-holiday');
    Route::middleware('auth:web')->post('/update-holiday', UpdateHolidayIntent::class)->name('holiday.update-holiday');
    Route::middleware('auth:web')->post('/get-holiday-list-data', GetHolidayListDataIntent::class)->name('holiday.get-holiday-list-data');
});
// calendar-dashboard
Route::prefix('calendar-dashboard')->group(function () {
    Route::middleware('auth:web')->post('/get-calendar-dashboard-list-data', GetCalendarDashboardListDataIntent::class)->name('calendar-dashboard.get-calendar-dashboard-list-data');
});

// special-class
Route::prefix('special-class')->group(function () {
    Route::middleware('auth:web')->post('/create-special-class', CreateSpecialClassIntent::class)->name('special-class.create-special-class');
    Route::middleware('auth:web')->post('/update-special-class', UpdateSpecialClassIntent::class)->name('special-class.update-special-class');
    Route::middleware('auth:web')->post('/get-special-class-list-data', GetSpecialClassListDataIntent::class)->name('special-class.get-special-class-list-data');
});
