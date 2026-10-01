<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentDetailsByClass;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentDetailsByClassUserDTO extends Data
{
    public function __construct(
        // user
        public int $grade_level_class_id,
        public int $page,
        public int $page_size,
        public ?string $search_phrase,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'grade_level_class_id' => ['required', 'integer', 'min:1'],
            'page' => ['required', 'integer', 'min:1'],
            'page_size' => ['required', 'integer', 'min:1', 'max:100'],
            'search_phrase' => ['nullable', 'string', 'max:255'],
        ];
    }
}
