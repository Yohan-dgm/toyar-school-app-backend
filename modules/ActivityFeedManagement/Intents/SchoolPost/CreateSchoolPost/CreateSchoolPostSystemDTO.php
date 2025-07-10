<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\CreateSchoolPost;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSchoolPostSystemDTO extends Data
{
    public function __construct(
        public int $author_id,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'author_id' => 'required|integer',
            'created_by' => 'required|integer',
        ];
    }
}
