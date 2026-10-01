<?php

namespace Modules\CommunicationManagement\Intents\Announcement\CreateAnnouncement;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateAnnouncementUserDTO extends Data
{
    public function __construct(
        public string $title,
        public string $content,
        public ?string $excerpt,
        public int $category_id,
        public int $priority_level,
        public string $status,
        public ?string $target_type,
        public ?array $target_data,
        public ?string $image_url,
        public ?array $attachment_urls,
        public ?bool $is_featured,
        public ?bool $is_pinned,
        public ?string $scheduled_at,
        public ?string $expires_at,
        // public ?int $school_id,
        public ?string $tags,
        public ?array $meta_data,
        public ?bool $save_announcement, // Control whether to save to announcements table
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'title' => 'required|string|max:500',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:1000',
            'category_id' => 'required|integer',
            'priority_level' => 'required|integer|in:1,2,3',
            'status' => 'required|in:draft,scheduled,published',
            'target_type' => 'nullable|string', // Allow any string for custom types like "Student", "Grade_Level"
            'target_data' => 'nullable|array',
            'target_data.roles' => 'array',
            'target_data.roles.*' => 'string',
            'target_data.user_ids' => 'array',
            'target_data.user_ids.*' => 'integer|exists:user,id',
            'target_data.student_ids' => 'array',
            'target_data.student_ids.*' => 'integer|exists:student,id',
            'target_data.student_id' => 'integer|exists:student,id',
            'target_data.grade_level_class_ids' => 'array',
            'target_data.grade_level_class_ids.*' => 'integer',
            'target_data.grade_level_class_id' => 'integer',
            'target_data.grade_level_ids' => 'array',
            'target_data.grade_level_ids.*' => 'integer',
            'target_data.grade_level_id' => 'integer',
            'target_data.group_filter' => 'string',
            'image_url' => 'nullable|string|max:500',
            'attachment_urls' => 'nullable|array',
            'attachment_urls.*' => 'string|max:500',
            'is_featured' => 'nullable|boolean',
            'is_pinned' => 'nullable|boolean',
            'scheduled_at' => 'nullable|date|after:now',
            'expires_at' => 'nullable|date|after:now',
            // 'school_id' => 'nullable|integer|exists:schools,id',
            'tags' => 'nullable|string|max:500',
            'meta_data' => 'nullable|array',
            'save_announcement' => 'nullable|boolean',
        ];
    }
}
