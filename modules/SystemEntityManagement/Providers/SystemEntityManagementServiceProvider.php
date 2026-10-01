<?php

namespace Modules\SystemEntityManagement\Providers;

use Illuminate\Support\ServiceProvider;

class SystemEntityManagementServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'system-entity-management');
    }
}
