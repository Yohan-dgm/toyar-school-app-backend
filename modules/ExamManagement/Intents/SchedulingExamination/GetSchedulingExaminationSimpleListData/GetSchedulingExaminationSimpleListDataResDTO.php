<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\GetSchedulingExaminationSimpleListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetSchedulingExaminationSimpleListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $scheduling_examinations_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // syste
        ];
    }
}
