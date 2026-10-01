<?php

use Illuminate\Support\Facades\Route;
use Modules\ServiceManagement\Intents\ServiceItem\CreateServiceItem\CreateServiceItemIntent;

// Service Item
Route::prefix('service-item')->group(function () {
    Route::middleware('auth:web')->post('/create-service-item', CreateServiceItemIntent::class)->name('service-item.create-service-item');
});
