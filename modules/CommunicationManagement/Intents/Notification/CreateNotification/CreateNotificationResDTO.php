<?php

namespace Modules\CommunicationManagement\Intents\Notification\CreateNotification;

use Spatie\LaravelData\Data;

class CreateNotificationResDTO extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public string $message,
        public string $priority,
        public string $target_type,
        public array $target_data,
        public ?string $action_url,
        public ?string $action_text,
        public ?string $image_url,
        public bool $is_scheduled,
        public ?string $scheduled_at,
        public ?string $sent_at,
        public ?string $expires_at,
        public int $total_recipients,
        public bool $is_active,
        public string $created_at,
        public string $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            message: $data['message'],
            priority: $data['priority'],
            target_type: $data['target_type'],
            target_data: $data['target_data'] ?? [],
            action_url: $data['action_url'] ?? null,
            action_text: $data['action_text'] ?? null,
            image_url: $data['image_url'] ?? null,
            is_scheduled: $data['is_scheduled'] ?? false,
            scheduled_at: $data['scheduled_at'] ?? null,
            sent_at: $data['sent_at'] ?? null,
            expires_at: $data['expires_at'] ?? null,
            total_recipients: $data['total_recipients'] ?? 0,
            is_active: $data['is_active'] ?? true,
            created_at: $data['created_at'],
            status: $data['sent_at'] ? 'sent' : ($data['is_scheduled'] ? 'scheduled' : 'draft'),
        );
    }
}
