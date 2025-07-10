<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\CreateSchoolPost;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchoolPostUserDTO extends Data
{
    public function __construct(
        public string $type,
        public ?string $category,
        public string $title,
        public string $content,
        public int $school_id,
        public ?int $class_id,
        public ?int $student_id,
        public ?array $media,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'type' => 'required|in:announcement,event,news,achievement',
            'category' => 'nullable|string|max:100',
            'title' => 'required|string|max:500',
            'content' => 'required|string',
            'school_id' => 'required|integer|exists:schools,id',
            'class_id' => 'nullable|integer',
            'student_id' => 'nullable|integer',
            'media' => 'nullable|array',
            'media.*.type' => 'required_with:media|in:image,video,pdf',
            'media.*.url' => 'required_with:media|string|max:500',
            'media.*.thumbnail_url' => 'nullable|string|max:500',
            'media.*.filename' => 'required_with:media|string|max:255',
            'media.*.size' => 'required_with:media|integer|min:0',
            'media.*.mime_type' => 'nullable|string|max:100',
        ];
    }
}
