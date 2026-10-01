<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\CreateSchoolPost;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchoolPostDTO extends Data
{
    public function __construct(
        // User data
        public ?string $type,
        public ?string $category,
        public string $title,
        public string $content,
        public ?int $school_id,
        public ?int $class_id,
        public ?int $student_id,
        public ?array $media,
        public ?array $hashtags,
        // System data
        public int $author_id,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // User data
            'type' => 'nullable|in:announcement,event,news,achievement',
            'category' => 'nullable|string|max:100',
            'title' => 'required|string|max:500',
            'content' => 'required|string',
            'school_id' => 'nullable',
            'class_id' => 'nullable|integer',
            'student_id' => 'nullable|integer',
            'media' => 'nullable|array',
            'hashtags' => 'nullable|array',
            'hashtags.*' => 'string|max:100',
            // System data
            'author_id' => 'required|integer',
            'created_by' => 'required|integer',
        ];
    }
}
