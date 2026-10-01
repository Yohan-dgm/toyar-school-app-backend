<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\CalendarManagement\Intents\Calendar\GetCalendarDataByMonth\GetCalendarDataByMonthIntent;
use Modules\CalendarManagement\Intents\CalendarDashboard\GetCalendarDashboardListData\GetCalendarDashboardListDataIntent;
use Modules\CalendarManagement\Intents\Event\ApprovalEvent\ApprovalEventIntent;
use Modules\CalendarManagement\Intents\Event\CreateEvent\CreateEventIntent;
use Modules\CalendarManagement\Intents\Event\GetEventListData\GetEventListDataIntent;
use Modules\CalendarManagement\Intents\Event\UpdateEvent\UpdateEventIntent;
use Modules\CalendarManagement\Intents\EventCategory\CreateEventCategory\CreateEventCategoryIntent;
use Modules\CalendarManagement\Intents\EventCategory\GetEventCategoryListData\GetEventCategoryListDataIntent;
use Modules\CalendarManagement\Intents\EventCategory\UpdateEventCategory\UpdateEventCategoryIntent;
use Modules\CalendarManagement\Intents\Holiday\CreateHoliday\CreateHolidayIntent;
use Modules\CalendarManagement\Intents\Holiday\GetHolidayListData\GetHolidayListDataIntent;
use Modules\CalendarManagement\Intents\Holiday\UpdateHoliday\UpdateHolidayIntent;
use Modules\CalendarManagement\Intents\SpecialClass\CreateSpecialClass\CreateSpecialClassIntent;
use Modules\CalendarManagement\Intents\SpecialClass\GetSpecialClassListData\GetSpecialClassListDataIntent;
use Modules\CalendarManagement\Intents\SpecialClass\UpdateSpecialClass\UpdateSpecialClassIntent;

// Event
Route::prefix('event')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-event', CreateEventIntent::class)->name('event.create-event');
    Route::middleware(AuthGuard::class)->post('/update-event', UpdateEventIntent::class)->name('event.update-event');
    Route::middleware(AuthGuard::class)->post('/get-event-list-data', GetEventListDataIntent::class)->name('event.get-event-list-data');
    Route::middleware(AuthGuard::class)->post('/approval-event', ApprovalEventIntent::class)->name('event.approval-event');
});

// Event Category
Route::prefix('event-category')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-event-category', CreateEventCategoryIntent::class)->name('event-category.create-event-category');
    Route::middleware(AuthGuard::class)->post('/update-event-category', UpdateEventCategoryIntent::class)->name('event-category.update-event-category');
    Route::middleware(AuthGuard::class)->post('/get-event-category-list-data', GetEventCategoryListDataIntent::class)->name('event-category.get-event-category-list-data');
});

// Holiday
Route::prefix('holiday')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-holiday', CreateHolidayIntent::class)->name('holiday.create-holiday');
    Route::middleware(AuthGuard::class)->post('/update-holiday', UpdateHolidayIntent::class)->name('holiday.update-holiday');
    Route::middleware(AuthGuard::class)->post('/get-holiday-list-data', GetHolidayListDataIntent::class)->name('holiday.get-holiday-list-data');
});
// Calendar Dashboard
Route::prefix('calendar-dashboard')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-calendar-dashboard-list-data', GetCalendarDashboardListDataIntent::class)->name('calendar-dashboard.get-calendar-dashboard-list-data');
});

// Special Class
Route::prefix('special-class')->group(function () {
    Route::middleware(AuthGuard::class)->post('/create-special-class', CreateSpecialClassIntent::class)->name('special-class.create-special-class');
    Route::middleware(AuthGuard::class)->post('/update-special-class', UpdateSpecialClassIntent::class)->name('special-class.update-special-class');
    Route::middleware(AuthGuard::class)->post('/get-special-class-list-data', GetSpecialClassListDataIntent::class)->name('special-class.get-special-class-list-data');
});

// Calendar
Route::prefix('calendar')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-month-data', GetCalendarDataByMonthIntent::class)->name('calendar.get-month-data');
});
