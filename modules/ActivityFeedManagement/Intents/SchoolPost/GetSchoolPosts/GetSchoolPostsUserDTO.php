<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\GetSchoolPosts;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetSchoolPostsUserDTO extends Data
{
    public function __construct(
        public ?int $school_id,
        public ?int $page,
        public ?int $page_size,
        public ?string $search_phrase,
        public ?array $search_filter_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'school_id' => 'nullable|integer',
            'page' => 'nullable|integer|min:1',
            'page_size' => 'nullable|integer|min:1|max:100',
            'search_phrase' => 'nullable|string|max:255',
            'search_filter_list' => 'nullable|array',
        ];
    }
}
