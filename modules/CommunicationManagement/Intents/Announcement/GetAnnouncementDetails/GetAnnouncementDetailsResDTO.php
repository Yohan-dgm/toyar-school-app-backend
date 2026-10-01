<?php

namespace Modules\CommunicationManagement\Intents\Announcement\GetAnnouncementDetails;

use Spatie\LaravelData\Data;

class GetAnnouncementDetailsResDTO extends Data
{
    public function __construct(
        public int $id,
        public string $title,
        public string $content,
        public ?string $excerpt,
        public array $category,
        public int $priority_level,
        public string $priority_label,
        public string $priority_color,
        public string $status,
        public string $status_label,
        public string $status_color,
        public string $target_type,
        public string $target_display,
        public ?array $target_data,
        public ?string $image_url,
        public ?array $attachment_urls,
        public bool $has_attachments,
        public int $attachment_count,
        public bool $is_featured,
        public bool $is_pinned,
        public ?string $scheduled_at,
        public ?string $published_at,
        public ?string $expires_at,
        public bool $is_expired,
        public int $view_count,
        public int $like_count,
        public array $tags_array,
        public int $read_time,
        public array $user_interaction,
        public array $creator,
        public string $created_at,
        public string $formatted_created_at,
        public ?string $time_ago,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            title: $data['title'],
            content: $data['content'],
            excerpt: $data['excerpt'],
            category: $data['category'],
            priority_level: $data['priority_level'],
            priority_label: $data['priority_label'],
            priority_color: $data['priority_color'],
            status: $data['status'],
            status_label: $data['status_label'],
            status_color: $data['status_color'],
            target_type: $data['target_type'],
            target_display: $data['target_display'],
            target_data: $data['target_data'],
            image_url: $data['image_url'],
            attachment_urls: $data['attachment_urls'],
            has_attachments: $data['has_attachments'],
            attachment_count: $data['attachment_count'],
            is_featured: $data['is_featured'],
            is_pinned: $data['is_pinned'],
            scheduled_at: $data['scheduled_at'],
            published_at: $data['published_at'],
            expires_at: $data['expires_at'],
            is_expired: $data['is_expired'],
            view_count: $data['view_count'],
            like_count: $data['like_count'],
            tags_array: $data['tags_array'],
            read_time: $data['read_time'],
            user_interaction: $data['user_interaction'],
            creator: $data['creator'],
            created_at: $data['created_at'],
            formatted_created_at: $data['formatted_created_at'],
            time_ago: $data['time_ago'],
        );
    }
}
