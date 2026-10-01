<?php

namespace App\Events;

use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatGroupDeleted implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $chatGroupId;

    /**
     * Create a new event instance.
     */
    public function __construct($chatGroupId)
    {
        $this->chatGroupId = $chatGroupId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PresenceChannel('chat.group.' . $this->chatGroupId),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'group.deleted';
    }
}
