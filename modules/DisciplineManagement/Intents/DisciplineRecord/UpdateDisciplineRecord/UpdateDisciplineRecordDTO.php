<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\UpdateDisciplineRecord;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateDisciplineRecordDTO extends Data
{
    public function __construct(
        // user
        public int $misconduct_level_id,
        public string $offence,
        public ?string $description,
        public string $incident_date,
        public int $marks_deducted,
        public ?string $override_reason,
        public ?string $disciplinary_action_taken,
        public ?bool $parent_informed,
        public ?string $student_response,
        // system
        public string $academic_year,
        public int $updated_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'misconduct_level_id' => [new Required, new IntegerType],
            'offence' => [new Required, new StringType],
            'description' => [],
            'incident_date' => [new Required, new Date],
            'marks_deducted' => [new Required, new IntegerType],
            'override_reason' => [],
            'disciplinary_action_taken' => [],
            'parent_informed' => [],
            'student_response' => [],
            // system
            'academic_year' => [new Required, new StringType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
