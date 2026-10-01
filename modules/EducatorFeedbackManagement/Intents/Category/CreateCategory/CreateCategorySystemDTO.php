<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\CreateCategory;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCategorySystemDTO extends Data
{
    public function __construct(
        // user

        // system
        public int $created_by,
        public ?int $updated_by,

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user

            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
