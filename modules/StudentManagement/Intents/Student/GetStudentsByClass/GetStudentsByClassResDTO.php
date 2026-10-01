<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentsByClass;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentsByClassResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
