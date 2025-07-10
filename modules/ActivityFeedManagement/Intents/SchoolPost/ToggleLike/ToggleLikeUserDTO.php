<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ToggleLikeUserDTO extends Data
{
    public function __construct(
        public int $post_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'post_id' => 'required|integer|exists:activity_feed_posts,id',
        ];
    }
}
