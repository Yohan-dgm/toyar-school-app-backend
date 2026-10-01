<?php

namespace Modules\DisciplineManagement\Providers;

use Illuminate\Support\ServiceProvider;

class DisciplineManagementServiceProvider extends ServiceProvider
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
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'discipline-management');
    }
}
