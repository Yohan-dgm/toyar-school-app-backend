<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\UpdateEducatorFeedback;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEducatorFeedbackUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public int $student_id,
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
            'id' => [new Required, new IntegerType],
            'student_id' => [new Required, new IntegerType],
            'grade_level_id' => [new Required, new IntegerType],
            'edu_fb_category_id' => [new Required, new IntegerType],
            'rating' => [new Numeric],
            'created_by_designation' => [new StringType],
            // system
        ];
    }
}
