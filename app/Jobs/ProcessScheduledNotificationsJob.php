<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\CommunicationManagement\Services\NotificationService;

class ProcessScheduledNotificationsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1; // This is a maintenance job, don't retry
    public $timeout = 300; // 5 minutes

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        $this->onQueue('notifications-maintenance');
    }

    /**
     * Execute the job.
     */
    public function handle(NotificationService $notificationService): void
    {
        try {
            Log::info('Starting scheduled notifications processing');

            $processed = $notificationService->processScheduledNotifications();

            Log::info('Scheduled notifications processing completed', [
                'processed_count' => $processed,
            ]);

        } catch (\Exception $e) {
            Log::error('Scheduled notifications processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            throw $e;
        }
    }

    /**
     * Get the tags for the job.
     */
    public function tags(): array
    {
        return [
            'scheduled-notifications',
            'maintenance',
        ];
    }
}