<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationDetails;

use Spatie\LaravelData\Data;

class GetNotificationDetailsResDTO extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public string $message,
        public string $priority,
        public string $priority_label,
        public string $priority_color,
        public array $type,
        public string $target_type,
        public string $target_display,
        public ?array $target_data,
        public ?string $action_url,
        public ?string $action_text,
        public ?string $image_url,
        public bool $is_read,
        public ?string $read_at,
        public bool $is_delivered,
        public ?string $delivered_at,
        public ?string $expires_at,
        public bool $is_expired,
        public array $stats,
        public array $creator,
        public string $created_at,
        public string $time_ago,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            message: $data['message'],
            priority: $data['priority'],
            priority_label: $data['priority_label'],
            priority_color: $data['priority_color'],
            type: $data['type'],
            target_type: $data['target_type'],
            target_display: $data['target_display'],
            target_data: $data['target_data'],
            action_url: $data['action_url'],
            action_text: $data['action_text'],
            image_url: $data['image_url'],
            is_read: $data['is_read'],
            read_at: $data['read_at'],
            is_delivered: $data['is_delivered'],
            delivered_at: $data['delivered_at'],
            expires_at: $data['expires_at'],
            is_expired: $data['is_expired'],
            stats: $data['stats'],
            creator: $data['creator'],
            created_at: $data['created_at'],
            time_ago: $data['time_ago'],
        );
    }
}
