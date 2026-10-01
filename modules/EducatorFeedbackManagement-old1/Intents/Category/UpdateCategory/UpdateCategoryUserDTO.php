<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\UpdateCategory;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $name,
        public ?bool $is_active,
        // system

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'name' => [new Required, new StringType],
            'is_active' => [new BooleanType],
            // system
        ];
    }
}
