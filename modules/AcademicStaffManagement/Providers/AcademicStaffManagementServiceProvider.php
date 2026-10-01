<?php

namespace Modules\AcademicStaffManagement\Providers;

use Illuminate\Support\ServiceProvider;

class AcademicStaffManagementServiceProvider extends ServiceProvider
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
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
        $this->mergeConfigFrom(__DIR__ . '/../config.php', 'academic-staff-management');
    }
}
