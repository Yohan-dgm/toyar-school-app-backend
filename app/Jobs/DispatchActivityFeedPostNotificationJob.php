<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\ActivityFeedManagement\Services\ActivityFeedPostNotificationService;
use Spatie\Multitenancy\Jobs\TenantAware;

/**
 * Resolves recipients and sends the push notification for a newly created
 * School/Student/Class post. Dispatched (rather than run inline) so that
 * recipient resolution - which can mean querying every active user for a
 * school-wide broadcast - never adds latency to the post-creation request.
 */
class DispatchActivityFeedPostNotificationJob implements ShouldQueue, TenantAware
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $backoff = [60, 300, 900];
    public $timeout = 120;

    public function __construct(
        private readonly string $section,
        private readonly int $postId,
    ) {
        $this->onQueue('push-normal');
    }

    public function handle(): void
    {
        ActivityFeedPostNotificationService::forPost($this->section, $this->postId);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('Activity feed post notification job permanently failed', [
            'section' => $this->section,
            'post_id' => $this->postId,
            'error' => $exception->getMessage(),
        ]);
    }
}
