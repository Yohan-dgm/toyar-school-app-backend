<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\CreateEducatorFeedback;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateEducatorFeedbackUserDTO extends Data
{
    public function __construct(
        // user
        public array $student_ids,
        public int $grade_level_id,
        public ?int $grade_level_class_id,
        public int $edu_fb_category_id,
        public ?float $rating,
        public ?string $decline_reason,
        public ?string $created_by_designation,
        public ?array $question_answers,
        public ?array $subcategories,
        public ?string $comments,
        // system

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'student_ids' => [new Required, 'array', 'min:1'],
            'student_ids.*' => [new Required, new IntegerType],
            'grade_level_id' => [new Required, new IntegerType],
            'edu_fb_category_id' => [new Required, new IntegerType],
            'rating' => [new Numeric],
            'comments' => [new StringType],
            // system
        ];
    }
}
