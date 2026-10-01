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

class NotificationCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Notification $notification;
    public NotificationRecipient $recipient;
    public $broadcastQueue;

    /**
     * Create a new event instance.
     */
    public function __construct(Notification $notification, NotificationRecipient $recipient)
    {
        $this->notification = $notification;
        $this->recipient = $recipient;
        
        // Set queue for broadcasting
        $this->broadcastQueue = 'broadcast-' . $notification->priority;
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
        return 'notification.created';
    }

    /**
     * Get the data to broadcast.
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification->id,
            'recipient_id' => $this->recipient->id,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'priority' => $this->notification->priority,
            'priority_label' => $this->notification->priority_label,
            'priority_color' => $this->notification->priority_color,
            'type' => $this->notification->notificationType?->slug ?? 'general',
            'type_name' => $this->notification->notificationType?->name ?? 'General',
            'action_url' => $this->notification->action_url,
            'action_text' => $this->notification->action_text,
            'image_url' => $this->notification->image_url,
            'is_read' => $this->recipient->is_read,
            'is_delivered' => $this->recipient->is_delivered,
            'created_at' => $this->notification->created_at->toISOString(),
            'time_ago' => $this->notification->time_ago,
        ];
    }

    /**
     * Determine if this event should broadcast.
     */
    public function broadcastWhen(): bool
    {
        return $this->notification->is_active && 
               !$this->notification->is_expired &&
               $this->recipient->user_id > 0;
    }
}