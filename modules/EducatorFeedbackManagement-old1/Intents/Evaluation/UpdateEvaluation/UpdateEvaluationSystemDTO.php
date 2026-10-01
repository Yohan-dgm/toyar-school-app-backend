<?php

namespace Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluation;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEvaluationSystemDTO extends Data
{
    public function __construct(
        // user
        // system
        public int $updated_by,

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            // system
            'updated_by' => [new IntegerType],
        ];
    }
}
