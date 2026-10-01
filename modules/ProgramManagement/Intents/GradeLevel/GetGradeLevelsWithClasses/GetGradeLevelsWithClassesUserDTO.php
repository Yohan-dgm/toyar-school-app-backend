<?php

namespace Modules\ProgramManagement\Intents\GradeLevel\GetGradeLevelsWithClasses;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetGradeLevelsWithClassesUserDTO extends Data
{
    public function __construct(
        // user
        public int $page,
        public int $page_size,
        public ?string $search_phrase,
        public ?string $group_filter,
        public ?array $search_filter_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'page' => ['required', 'integer', 'min:1'],
            'page_size' => ['required', 'integer', 'min:1', 'max:100'],
            'search_phrase' => ['nullable', 'string', 'max:255'],
            'group_filter' => ['nullable', 'string'],
            'search_filter_list' => ['nullable', 'array'],
        ];
    }
}
