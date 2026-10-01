<?php

namespace Modules\ExamManagement\Intents\ExamMarkSubject\GetExamMarkSubjectListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetExamMarkSubjectListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $exam_mark_subject_count,
        public ?object $pending_confirmation_count,
        public ?object $confirmed_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // syste
        ];
    }
}
