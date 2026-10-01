<?php

namespace Modules\PurchasingManagement\Providers;

use Illuminate\Support\ServiceProvider;

class PurchasingManagementServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //PurchasingManagement
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__.'/../config.php', 'purchasing-management');
    }
}
