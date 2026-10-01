<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Services\ExpoPushNotificationService;
use Spatie\Multitenancy\Jobs\TenantAware;

class SendPushNotificationJob implements ShouldQueue, TenantAware
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Notification $notification;

    public $tries = 3;
    public $backoff = [60, 300, 900]; // 1 minute, 5 minutes, 15 minutes
    public $timeout = 120; // 2 minutes

    /**
     * Create a new job instance.
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
        
        // Set queue based on priority
        $this->onQueue($this->getQueueName($notification->priority));
    }

    /**
     * Execute the job.
     */
    public function handle(ExpoPushNotificationService $pushService): void
    {
        try {
            Log::channel('single')->info('Starting push notification job', [
                'notification_id' => $this->notification->id,
                'attempt' => $this->attempts(),
            ]);

            // Send push notifications
            $results = $pushService->sendNotificationPushes($this->notification);

            // Log results summary
            $successCount = collect($results)->where('success', true)->count();
            $failureCount = collect($results)->where('success', false)->count();

            Log::channel('single')->info('Push notification job completed', [
                'notification_id' => $this->notification->id,
                'success_count' => $successCount,
                'failure_count' => $failureCount,
                'attempt' => $this->attempts(),
            ]);

            // Update notification stats after push attempts
            $this->notification->updateStats();

        } catch (\Exception $e) {
            Log::error('Push notification job failed', [
                'notification_id' => $this->notification->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'attempt' => $this->attempts(),
            ]);

            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Push notification job permanently failed', [
            'notification_id' => $this->notification->id,
            'error' => $exception->getMessage(),
            'final_attempt' => $this->attempts(),
        ]);
    }

    /**
     * Get the queue name based on priority.
     */
    private function getQueueName(string $priority): string
    {
        return match ($priority) {
            'urgent' => 'push-urgent',
            'high' => 'push-high',
            'normal' => 'push-normal',
            default => 'push-normal',
        };
    }

    /**
     * Get the tags for the job.
     */
    public function tags(): array
    {
        return [
            'push-notification',
            'notification:' . $this->notification->id,
            'priority:' . $this->notification->priority,
        ];
    }
}