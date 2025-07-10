<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\UpdateSchoolPost;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSchoolPostDTO extends Data
{
    public function __construct(
        // User data
        public int $id,
        public ?string $type,
        public ?string $category,
        public ?string $title,
        public ?string $content,
        public ?array $media,
        // System data
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // User data
            'id' => 'required|integer',
            'type' => 'nullable|in:announcement,event,news,achievement',
            'category' => 'nullable|string|max:100',
            'title' => 'nullable|string|max:500',
            'content' => 'nullable|string',
            'media' => 'nullable|array',
            // System data
            'updated_by' => 'required|integer',
        ];
    }
}
