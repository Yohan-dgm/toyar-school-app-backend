<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;

class NotificationRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Notification $notification;
    public NotificationRecipient $recipient;
    public int $unreadCount;
    public $broadcastQueue;

    /**
     * Create a new event instance.
     */
    public function __construct(Notification $notification, NotificationRecipient $recipient, int $unreadCount = 0)
    {
        $this->notification = $notification;
        $this->recipient = $recipient;
        $this->unreadCount = $unreadCount;
        
        // Set queue for broadcasting
        $this->broadcastQueue = 'broadcast-normal';
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('user.' . $this->recipient->user_id . '.notifications'),
        ];
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'notification.read';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'notification_id' => $this->notification->id,
            'recipient_id' => $this->recipient->id,
            'is_read' => true,
            'read_at' => $this->recipient->read_at?->toISOString(),
            'unread_count' => $this->unreadCount,
        ];
    }

    /**
     * Determine if this event should broadcast.
     */
    public function broadcastWhen(): bool
    {
        return $this->recipient->user_id > 0;
    }
}