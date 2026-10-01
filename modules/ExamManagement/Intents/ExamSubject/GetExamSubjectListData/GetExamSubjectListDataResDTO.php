<?php

namespace Modules\ExamManagement\Intents\ExamSubject\GetExamSubjectListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetExamSubjectListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $exam_subject_count,
        public ?object $exam_subject_category_exam_subject_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // syste
        ];
    }
}
