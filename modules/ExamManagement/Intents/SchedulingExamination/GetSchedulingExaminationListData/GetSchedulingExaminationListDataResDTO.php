<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\GetSchedulingExaminationListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetSchedulingExaminationListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $scheduling_examinations_count,
        public ?object $scheduling_examinations_status_type_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // syste
        ];
    }
}
