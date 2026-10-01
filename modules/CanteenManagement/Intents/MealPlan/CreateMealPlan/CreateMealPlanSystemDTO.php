<?php

namespace Modules\CanteenManagement\Intents\MealPlan\CreateMealPlan;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMealPlanSystemDTO extends Data
{
    public function __construct(
        public string $image_path,
        public bool $is_active,
        public int $created_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'image_path' => [new Required, new StringType],
            'is_active' => [],
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
