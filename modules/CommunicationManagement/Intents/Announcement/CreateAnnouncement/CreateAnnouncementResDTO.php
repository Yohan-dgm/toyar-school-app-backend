<?php

namespace Modules\CommunicationManagement\Intents\Announcement\CreateAnnouncement;

use Spatie\LaravelData\Data;

class CreateAnnouncementResDTO extends Data
{
    public function __construct(
        // Primary notification data
        public int $id,
        public int $notification_id,
        public string $title,
        public string $message,
        public string $priority,
        public string $target_type,
        public ?array $target_data,
        public ?string $action_url,
        public ?string $action_text,
        public ?string $image_url,
        public bool $is_scheduled,
        public ?string $scheduled_at,
        public ?string $sent_at,
        public ?string $expires_at,
        public int $total_recipients,
        public bool $is_active,
        public ?array $metadata,
        public string $created_at,
        
        // Notification status flags
        public bool $notification_sent,
        public bool $push_notifications_sent,
        
        // Optional announcement data
        public ?array $announcement,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            // Primary notification data
            id: $data['id'],
            notification_id: $data['notification_id'],
            title: $data['title'],
            message: $data['message'],
            priority: $data['priority'],
            target_type: $data['target_type'],
            target_data: $data['target_data'],
            action_url: $data['action_url'],
            action_text: $data['action_text'],
            image_url: $data['image_url'],
            is_scheduled: $data['is_scheduled'],
            scheduled_at: $data['scheduled_at'],
            sent_at: $data['sent_at'],
            expires_at: $data['expires_at'],
            total_recipients: $data['total_recipients'],
            is_active: $data['is_active'],
            metadata: $data['metadata'],
            created_at: $data['created_at'],
            
            // Notification status flags
            notification_sent: $data['notification_sent'],
            push_notifications_sent: $data['push_notifications_sent'],
            
            // Optional announcement data
            announcement: $data['announcement'],
        );
    }
}
