<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ToggleLikeSystemDTO extends Data
{
    public function __construct(
        public int $user_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => 'required|integer',
        ];
    }
}
