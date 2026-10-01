<?php

namespace Modules\ExamManagement\Intents\ExamSubject\CreateExamSubject;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamSubjectDTO extends Data
{
    public function __construct(
        // user
        public int $exam_subject_category_id,
        public string $name,
        public string $exam_subject_code,
        public ?string $exam_subject_components,
        public ?bool $has_practical_component,
        public ?string $exam_subject_option_code,
        public float $exam_subject_fee,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType],

            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
