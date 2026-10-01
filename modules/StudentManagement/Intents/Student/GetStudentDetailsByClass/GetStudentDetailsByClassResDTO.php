<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentDetailsByClass;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentDetailsByClassResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public int $current_page,
        public int $per_page,
        public ?int $student_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
