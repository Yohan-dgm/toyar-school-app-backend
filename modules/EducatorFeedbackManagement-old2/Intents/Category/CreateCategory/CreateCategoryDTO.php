<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\CreateCategory;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCategoryDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public ?bool $is_active,
        public ?array $predefined_questions,
        // system
        public int $created_by,
        public ?int $updated_by,

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType],
            'is_active' => [new BooleanType],
            'predefined_questions' => ['sometimes', 'array'],
            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
