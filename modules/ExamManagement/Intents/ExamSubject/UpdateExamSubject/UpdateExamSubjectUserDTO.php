<?php

namespace Modules\ExamManagement\Intents\ExamSubject\UpdateExamSubject;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamSubjectUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public ?int $exam_subject_category_id,
        public ?string $name,
        public ?string $exam_subject_code,
        public ?string $exam_subject_components,
        public ?bool $has_practical_component,
        public ?string $exam_subject_option_code,
        public ?array $exam_subject_group_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'name' => [new Required, new StringType],
        ];
    }
}
