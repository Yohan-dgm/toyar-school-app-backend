<?php

namespace Modules\SportManagement\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SportManagementServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->register(\Modules\SportManagement\Providers\SportManagementServiceProvider::class);
    }

    public function boot(): void
    {
        $this->loadRoutes();
    }

    protected function loadRoutes(): void
    {
        if (file_exists(__DIR__.'/../routes.php')) {
            Route::middleware(['api'])
                ->prefix('api/sport-management')
                ->name('sport-management.')
                ->group(__DIR__.'/../routes.php');
        }
    }
}
