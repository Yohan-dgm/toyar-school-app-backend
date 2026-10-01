<?php

namespace Modules\EducatorFeedbackManagement\Providers;

use Illuminate\Support\ServiceProvider;

class EducatorFeedbackManagementServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/migrations');
    }
}
