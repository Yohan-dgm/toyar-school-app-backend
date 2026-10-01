<?php

namespace Modules\ExamManagement\Intents\StudentExamMark\GetStudentExamMarkListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentExamMarkListDataUserDTO extends Data
{
    public function __construct(
        // user
        public ?string $group_filter,
        public ?array $search_filter_list,
        public ?string $search_phrase,
        public int $page_size,
        public int $page,
        public ?int $scheduling_examination_grade_subject_id,
        // system

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
