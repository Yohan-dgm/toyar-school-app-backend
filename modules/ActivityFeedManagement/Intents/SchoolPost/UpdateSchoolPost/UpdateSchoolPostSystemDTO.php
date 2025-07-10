<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\UpdateSchoolPost;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSchoolPostSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => 'required|integer',
        ];
    }
}
