<?php

namespace Modules\MaterialManagement\Providers;

use Illuminate\Support\ServiceProvider;

class MaterialManagementServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //MaterialManagement
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'material-management');
    }
}
