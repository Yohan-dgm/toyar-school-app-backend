<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\GetStudentDisciplineSummary;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentDisciplineSummaryUserDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public ?string $academic_year,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required, new IntegerType],
            'academic_year' => [],
            // system
        ];
    }
}
