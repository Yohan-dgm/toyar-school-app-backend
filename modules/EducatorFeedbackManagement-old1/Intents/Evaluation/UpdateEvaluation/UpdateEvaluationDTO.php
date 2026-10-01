<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluation;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEvaluationDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public ?int $edu_fd_evaluation_type_id,
        public ?string $reviewer_feedback,
        public ?string $decline_reason,
        public ?bool $is_parent_visible,
        public ?bool $is_active,
        // system
        public int $updated_by,

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'edu_fd_evaluation_type_id' => [new IntegerType],
            'reviewer_feedback' => [new StringType],
            'decline_reason' => [new StringType],
            'is_parent_visible' => [new BooleanType],
            'is_active' => [new BooleanType],
            // system
            'updated_by' => [new IntegerType],
        ];
    }
}
