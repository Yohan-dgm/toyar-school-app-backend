<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\CreateEducatorFeedback;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateEducatorFeedbackSystemDTO extends Data
{
    public function __construct(
        // user

        // system
        public int $status,
        public int $created_by,
        public ?int $updated_by,

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user

            // system
            'status' => [new Required, new IntegerType],
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
