<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentsByClass;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentsByClassUserDTO extends Data
{
    public function __construct(
        // user
        public int $grade_level_class_id,
        // system

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'grade_level_class_id' => [new Required, new IntegerType],
            // system
        ];
    }
}
