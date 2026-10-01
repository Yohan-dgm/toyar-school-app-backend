<?php

namespace Modules\ExamManagement\Intents\ExamQuizItem\UpdateExamQuizMarks;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamQuizMarksDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public int $marks,
        public int $exam_quiz_item_id,
        public string $present_type,
        // system
        // public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'marks' => [new Required],
            'present_type' => [new Required],

            // system
            // "updated_by" =>  [new Required(), new IntegerType()],
        ];
    }
}
