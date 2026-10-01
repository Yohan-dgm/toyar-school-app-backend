<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluationStatus;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEvaluationStatusUserDTO extends Data
{
    public function __construct(
        // user
        public int $edu_fb_id,
        public int $edu_fd_evaluation_type_id,
        public ?string $reviewer_feedback,
        public ?string $decline_reason,
        public ?bool $is_parent_visible,
        // system

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'edu_fb_id' => [new Required, new IntegerType],
            'edu_fd_evaluation_type_id' => [new Required, new IntegerType],
            'reviewer_feedback' => [new StringType],
            'decline_reason' => [new StringType],
            'is_parent_visible' => [new BooleanType],
            // system
        ];
    }
}
