<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Process scheduled notifications every 5 minutes
        $schedule->command('notifications:process-scheduled')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->runInBackground()
            ->onOneServer();

        // Clean up push tokens daily at 2 AM
        $schedule->command('push-tokens:cleanup')
            ->dailyAt('02:00')
            ->withoutOverlapping()
            ->runInBackground()
            ->onOneServer();

        // Clean up old notifications weekly
        $schedule->call(function () {
            $notificationService = app(\Modules\CommunicationManagement\Services\NotificationService::class);
            $cleaned = $notificationService->cleanupOldNotifications(90); // 90 days
            \Log::info("Cleaned up {$cleaned} old notifications");
        })
        ->weekly()
        ->sundays()
        ->at('03:00')
        ->name('cleanup-old-notifications')
        ->withoutOverlapping()
        ->runInBackground()
        ->onOneServer();

        // Clean up expired notifications daily at 3 AM
        $schedule->call(function () {
            $notificationService = app(\Modules\CommunicationManagement\Services\NotificationService::class);
            $cleaned = $notificationService->cleanupExpiredNotifications();
            \Log::info("Cleaned up {$cleaned} expired notifications");
        })
        ->dailyAt('03:00')
        ->name('cleanup-expired-notifications')
        ->withoutOverlapping()
        ->runInBackground()
        ->onOneServer();

        // Monitor push notification health every hour
        $schedule->call(function () {
            $pushService = app(\Modules\CommunicationManagement\Services\ExpoPushNotificationService::class);
            $stats = $pushService->getPushStats();
            
            // Log warning if health percentage is below threshold
            if ($stats['health_percentage'] < 80) {
                \Log::warning('Push notification health below threshold', $stats);
            }
            
            // Log critical alert if too many tokens are failing
            if ($stats['tokens_exceeding_threshold'] > 100) {
                \Log::critical('High number of failing push tokens detected', $stats);
            }
        })
        ->hourly()
        ->name('monitor-push-health')
        ->withoutOverlapping()
        ->runInBackground()
        ->onOneServer();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}