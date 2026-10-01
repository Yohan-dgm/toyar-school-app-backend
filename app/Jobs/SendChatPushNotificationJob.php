<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Modules\CommunicationManagement\Models\ChatGroup;
use Modules\CommunicationManagement\Models\ChatMessage;
use Modules\CommunicationManagement\Services\ChatPushNotificationService;
use Spatie\Multitenancy\Jobs\TenantAware;

class SendChatPushNotificationJob implements ShouldQueue, TenantAware
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected ChatGroup $group;
    protected ChatMessage $message;
    protected int $senderId;

    public $tries = 3;
    public $backoff = [30, 60, 120];
    public $timeout = 60;

    /**
     * Create a new job instance.
     */
    public function __construct(ChatGroup $group, ChatMessage $message, int $senderId)
    {
        $this->group = $group;
        $this->message = $message;
        $this->senderId = $senderId;
        
        $this->onQueue('push-normal');
    }

    /**
     * Execute the job.
     */
    public function handle(ChatPushNotificationService $pushService): void
    {
        try {
            Log::info('Starting chat push notification job', [
                'chat_group_id' => $this->group->id,
                'message_id' => $this->message->id,
            ]);

            $pushService->sendChatPushes($this->group, $this->message, $this->senderId);

        } catch (\Exception $e) {
            Log::error('Chat push notification job failed', [
                'chat_group_id' => $this->group->id,
                'message_id' => $this->message->id,
                'error' => $e->getMessage(),
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
            'chat-push',
            'group:' . $this->group->id,
            'message:' . $this->message->id,
        ];
    }
}
