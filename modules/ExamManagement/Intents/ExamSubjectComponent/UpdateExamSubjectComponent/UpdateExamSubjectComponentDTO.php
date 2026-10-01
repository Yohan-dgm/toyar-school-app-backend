<?php

namespace Modules\ExamManagement\Intents\ExamSubjectComponent\UpdateExamSubjectComponent;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamSubjectComponentDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public int $exam_subject_component_type_id,
        public string $exam_subject_id,
        // system
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'exam_subject_component_type_id' => [new Required, new IntegerType],
            'exam_subject_id' => [new Required, new IntegerType],

            // system
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
