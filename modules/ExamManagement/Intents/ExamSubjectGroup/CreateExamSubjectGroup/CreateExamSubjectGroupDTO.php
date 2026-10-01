<?php

namespace Modules\ExamManagement\Intents\ExamSubjectGroup\CreateExamSubjectGroup;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamSubjectGroupDTO extends Data
{
    public function __construct(
        // user
        public string $name,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType, new Unique('exam_subject_group', 'name')],

            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
