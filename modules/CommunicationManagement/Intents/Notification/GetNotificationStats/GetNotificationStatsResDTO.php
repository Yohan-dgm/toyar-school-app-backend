<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationStats;

use Spatie\LaravelData\Data;

class GetNotificationStatsResDTO extends Data
{
    public function __construct(
        public int $total_notifications,
        public int $unread_count,
        public array $unread_by_priority,      // ['normal' => int, 'high' => int, 'urgent' => int]
        public array $recent_activity,         // ['today' => int, 'this_week' => int, 'this_month' => int]
        public array $by_type,                 // [type_id => ['name' => string, 'count' => int, 'unread' => int]]
        public array $priority_breakdown,      // ['normal' => int, 'high' => int, 'urgent' => int]
        public ?string $last_notification_at,
        public string $generated_at,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            total_notifications: $data['total_notifications'],
            unread_count: $data['unread_count'],
            unread_by_priority: $data['unread_by_priority'],
            recent_activity: $data['recent_activity'],
            by_type: $data['by_type'],
            priority_breakdown: $data['priority_breakdown'],
            last_notification_at: $data['last_notification_at'],
            generated_at: $data['generated_at'],
        );
    }
}
