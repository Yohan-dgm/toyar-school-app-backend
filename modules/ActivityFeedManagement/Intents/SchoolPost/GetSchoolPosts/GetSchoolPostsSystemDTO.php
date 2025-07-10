<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\GetSchoolPosts;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetSchoolPostsSystemDTO extends Data
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
