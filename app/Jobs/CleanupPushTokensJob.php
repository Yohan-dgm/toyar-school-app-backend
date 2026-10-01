<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\CommunicationManagement\Services\ExpoPushNotificationService;

class CleanupPushTokensJob implements ShouldQueue
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
    public function handle(ExpoPushNotificationService $pushService): void
    {
        try {
            Log::info('Starting push tokens cleanup');

            $result = $pushService->cleanupTokens();

            Log::info('Push tokens cleanup completed', [
                'cleaned_tokens' => $result['cleaned_tokens'],
            ]);

        } catch (\Exception $e) {
            Log::error('Push tokens cleanup failed', [
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
            'cleanup',
            'push-tokens',
            'maintenance',
        ];
    }
}