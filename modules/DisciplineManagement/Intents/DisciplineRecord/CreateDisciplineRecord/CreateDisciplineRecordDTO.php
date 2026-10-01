<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\CreateDisciplineRecord;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateDisciplineRecordDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
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
        public ?string $grade_class_at_time,
        public string $status,
        public int $reported_by,
        public ?int $reviewed_by,
        public ?string $reviewed_date,
        public int $created_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required, new IntegerType],
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
            'grade_class_at_time' => [],
            'status' => [new Required, new StringType],
            'reported_by' => [new Required, new IntegerType],
            'reviewed_by' => [],
            'reviewed_date' => [],
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
