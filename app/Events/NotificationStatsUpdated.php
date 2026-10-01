<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationStatsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $userId;
    public int $unreadCount;
    public int $urgentCount;
    public $broadcastQueue;

    /**
     * Create a new event instance.
     */
    public function __construct(int $userId, int $unreadCount, int $urgentCount = 0)
    {
        $this->userId = $userId;
        $this->unreadCount = $unreadCount;
        $this->urgentCount = $urgentCount;
        
        // Set queue for broadcasting
        $this->broadcastQueue = 'broadcast-normal';
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->userId . '.notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'notification.stats.updated';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'unread_count' => $this->unreadCount,
            'urgent_count' => $this->urgentCount,
            'timestamp' => now()->toISOString(),
        ];
    }

    /**
     * Determine if this event should broadcast.
     */
    public function broadcastWhen(): bool
    {
        return $this->userId > 0;
    }
}