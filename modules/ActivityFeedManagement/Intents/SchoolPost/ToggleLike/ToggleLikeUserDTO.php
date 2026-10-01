<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ToggleLikeUserDTO extends Data
{
    public function __construct(
        public int $post_id,
        public string $action,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'post_id' => 'required|integer|exists:school_posts,id',
            'action' => 'required|string|in:like,unlike',
        ];
    }
}
