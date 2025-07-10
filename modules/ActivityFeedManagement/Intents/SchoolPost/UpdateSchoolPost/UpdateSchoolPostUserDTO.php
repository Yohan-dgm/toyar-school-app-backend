<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\UpdateSchoolPost;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSchoolPostUserDTO extends Data
{
    public function __construct(
        public int $id,
        public ?string $type,
        public ?string $category,
        public ?string $title,
        public ?string $content,
        public ?array $media,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'id' => 'required|integer|exists:activity_feed_posts,id',
            'type' => 'nullable|in:announcement,event,news,achievement',
            'category' => 'nullable|string|max:100',
            'title' => 'nullable|string|max:500',
            'content' => 'nullable|string',
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
