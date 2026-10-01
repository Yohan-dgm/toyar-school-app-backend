<?php

namespace Modules\EventManagement\Providers;

use Illuminate\Support\ServiceProvider;

class EventManagementServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'event-management');
    }
}
