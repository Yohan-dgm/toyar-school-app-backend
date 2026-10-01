<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\CreateCategory;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public ?bool $is_active,
        public ?array $predefined_questions,
        // system

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType],
            'is_active' => [new BooleanType],
            'predefined_questions' => ['sometimes', 'array'],
            'predefined_questions.*.question' => [new Required, new StringType],
            'predefined_questions.*.edu_fb_answer_type_id' => ['nullable', new IntegerType],
            'predefined_questions.*.is_active' => [new BooleanType],
            'predefined_questions.*.predefined_answers' => ['sometimes', 'array'],
            'predefined_questions.*.predefined_answers.*.predefined_answer' => [new Required, new StringType],
            'predefined_questions.*.predefined_answers.*.predefined_answer_weight' => ['nullable', new IntegerType],
            'predefined_questions.*.predefined_answers.*.marks' => ['nullable', new IntegerType],
            'predefined_questions.*.predefined_answers.*.is_active' => [new BooleanType],
            // system
        ];
    }
}
