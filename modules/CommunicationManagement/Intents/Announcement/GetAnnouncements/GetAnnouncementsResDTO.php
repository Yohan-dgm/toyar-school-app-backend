<?php

namespace Modules\CommunicationManagement\Intents\Announcement\GetAnnouncements;

use Spatie\LaravelData\Data;

class GetAnnouncementsResDTO extends Data
{
    public function __construct(
        public array $announcements,
        public array $categories,
        public array $pagination,
        public array $stats,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            announcements: $data['announcements'],
            categories: $data['categories'],
            pagination: $data['pagination'],
            stats: $data['stats'],
        );
    }

    public static function formatAnnouncement(array $announcement, ?array $recipient = null): array
    {
        return [
            'id' => $announcement['id'],
            'title' => $announcement['title'],
            'excerpt' => $announcement['excerpt'] ?? substr(strip_tags($announcement['content']), 0, 150).'...',
            'category' => [
                'id' => $announcement['category_id'] ?? null,
                'name' => $announcement['category_name'] ?? null,
                'slug' => $announcement['category_slug'] ?? null,
                'color' => $announcement['category_color'] ?? '#3b82f6',
                'icon' => $announcement['category_icon'] ?? 'megaphone',
            ],
            'priority_level' => $announcement['priority_level'],
            'priority_label' => match ($announcement['priority_level']) {
                3 => 'High',
                2 => 'Medium',
                1 => 'Low',
                default => 'Low'
            },
            'priority_color' => match ($announcement['priority_level']) {
                3 => '#ef4444',
                2 => '#f59e0b',
                1 => '#6b7280',
                default => '#6b7280'
            },
            'status' => $announcement['status'],
            'status_label' => match ($announcement['status']) {
                'published' => 'Published',
                'scheduled' => 'Scheduled',
                'draft' => 'Draft',
                'archived' => 'Archived',
                default => 'Unknown'
            },
            'is_featured' => $announcement['is_featured'] ?? false,
            'is_pinned' => $announcement['is_pinned'] ?? false,
            'image_url' => $announcement['image_url'],
            'published_at' => $announcement['published_at'],
            'scheduled_at' => $announcement['scheduled_at'],
            'expires_at' => $announcement['expires_at'],
            'view_count' => $announcement['view_count'] ?? 0,
            'like_count' => $announcement['like_count'] ?? 0,
            'is_read' => $recipient['is_read'] ?? false,
            'is_liked' => $recipient['is_liked'] ?? false,
            'user_view_count' => $recipient['view_count'] ?? 0,
            'created_at' => $announcement['created_at'],
            'time_ago' => $announcement['time_ago'] ?? null,
        ];
    }
}
