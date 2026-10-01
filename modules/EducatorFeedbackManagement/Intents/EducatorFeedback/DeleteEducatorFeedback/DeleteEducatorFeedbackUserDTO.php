<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\DeleteEducatorFeedback;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class DeleteEducatorFeedbackUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        // system

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            // system
        ];
    }
}
