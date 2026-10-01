<?php

namespace Modules\ExamManagement\Intents\ExamQuizItem\GetExamQuizItemListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetExamQuizItemListDataUserDTO extends Data
{
    public function __construct(
        // user
        public ?string $group_filter,
        public ?array $search_filter_list,
        public ?string $search_phrase,
        public int $page_size,
        public int $page,
        public ?int $exam_quiz_id,
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
