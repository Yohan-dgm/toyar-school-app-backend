<?php

namespace Modules\ExamManagement\Intents\ExamSubjectCategory\CreateExamSubjectCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamSubjectCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public string $name,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType, new Unique('exam_subject_category', 'name')],
        ];
    }
}
