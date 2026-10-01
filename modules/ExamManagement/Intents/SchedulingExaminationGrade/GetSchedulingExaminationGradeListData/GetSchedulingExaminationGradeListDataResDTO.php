<?php

namespace Modules\ExamManagement\Intents\SchedulingExaminationGrade\GetSchedulingExaminationGradeListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetSchedulingExaminationGradeListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $scheduling_examination_grades_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // syste
        ];
    }
}
