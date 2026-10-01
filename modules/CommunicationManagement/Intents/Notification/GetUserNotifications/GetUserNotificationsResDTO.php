<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetUserNotifications;

use Spatie\LaravelData\Data;

class GetUserNotificationsResDTO extends Data
{
    public function __construct(
        public array $notifications,
        public array $pagination,
        public array $stats,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            notifications: $data['notifications'],
            pagination: $data['pagination'],
            stats: $data['stats'],
        );
    }

    public static function formatNotification(array $notification, ?array $recipient = null): array
    {
        return [
            'id' => $notification['id'],
            'title' => $notification['title'],
            'message' => $notification['message'],
            'priority' => $notification['priority'],
            'priority_label' => match ($notification['priority']) {
                'urgent' => 'Urgent',
                'high' => 'High Priority',
                'normal' => 'Normal',
                default => 'Normal'
            },
            'priority_color' => match ($notification['priority']) {
                'urgent' => '#ef4444',
                'high' => '#f59e0b',
                'normal' => '#6b7280',
                default => '#6b7280'
            },
            'type' => [
                'id' => $notification['notification_type_id'] ?? null,
                'name' => $notification['type_name'] ?? null,
                'slug' => $notification['type_slug'] ?? null,
                'icon' => $notification['type_icon'] ?? 'bell',
                'color' => $notification['type_color'] ?? '#6b7280',
            ],
            'action_url' => $notification['action_url'],
            'action_text' => $notification['action_text'],
            'image_url' => $notification['image_url'],
            'is_read' => $recipient['is_read'] ?? false,
            'read_at' => $recipient['read_at'] ?? null,
            'is_delivered' => $recipient['is_delivered'] ?? false,
            'delivered_at' => $recipient['delivered_at'] ?? null,
            'expires_at' => $notification['expires_at'],
            'is_expired' => $notification['expires_at'] && $notification['expires_at'] < now(),
            'created_at' => $notification['created_at'],
            'time_ago' => $notification['time_ago'] ?? null,
        ];
    }
}
