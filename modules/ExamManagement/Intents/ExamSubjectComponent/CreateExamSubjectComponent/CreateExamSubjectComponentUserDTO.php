<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponent\CreateExamSubjectComponent;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamSubjectComponentUserDTO extends Data
{
    public function __construct(
        // user
        public int $exam_subject_component_type_id,
        public int $exam_subject_id,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'exam_subject_component_type_id' => [new Required, new IntegerType],
            'exam_subject_id' => [new Required, new IntegerType],
        ];
    }
}
