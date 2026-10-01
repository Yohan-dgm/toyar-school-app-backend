<?php

use Illuminate\Support\Facades\Route;
use Modules\EventManagement\Intents\Event\CreateEvent\CreateEventIntent;
use Modules\EventManagement\Intents\Event\UpdateEvent\UpdateEventIntent;

// event
Route::prefix('event')->group(function () {
    Route::middleware('auth:web')->post('/create-event', CreateEventIntent::class)->name('event.create-event');
    Route::middleware('auth:web')->post('/update-event', UpdateEventIntent::class)->name('event.update-event');
});
