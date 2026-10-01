<?php

namespace Modules\CommunicationManagement\Intents\Announcement\GetAnnouncements;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetAnnouncementsDTO extends Data
{
    public function __construct(
        public ?int $page,
        public ?int $per_page,
        public ?int $category_id,
        public ?int $priority_level,
        public ?string $status,
        public ?string $search,
        public ?string $date_from,
        public ?string $date_to,
        public ?bool $featured_only,
        public ?bool $pinned_only,
        public ?string $sort_by,
        public ?string $sort_order,
        public int $user_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'category_id' => 'nullable|integer|exists:announcement_categories,id',
            'priority_level' => 'nullable|integer|in:1,2,3',
            'status' => 'nullable|in:draft,scheduled,published,archived',
            'search' => 'nullable|string|max:255',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'featured_only' => 'nullable|boolean',
            'pinned_only' => 'nullable|boolean',
            'sort_by' => 'nullable|in:created_at,published_at,title,priority_level,view_count',
            'sort_order' => 'nullable|in:asc,desc',
            'user_id' => 'required|integer|exists:user,id',
        ];
    }
}
