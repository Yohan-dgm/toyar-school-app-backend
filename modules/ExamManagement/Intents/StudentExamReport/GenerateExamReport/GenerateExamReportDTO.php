<?php

namespace Modules\ExamManagement\Intents\StudentExamReport\GenerateExamReport;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GenerateExamReportDTO extends Data
{
    public function __construct(
        // user
        public int $scheduling_examinations_id,
        public int $scheduling_examinations_grade_id,
        // system
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'scheduling_examinations_id' => [new Required, new IntegerType],
            'scheduling_examinations_grade_id' => [new Required, new IntegerType],

            // system
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
