<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ToggleLikeDTO extends Data
{
    public function __construct(
        // User data
        public int $post_id,
        public string $action,
        // System data
        public int $user_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // User data
            'post_id' => 'required|integer',
            'action' => 'required|string|in:like,unlike',
            // System data
            'user_id' => 'required|integer',
        ];
    }
}
