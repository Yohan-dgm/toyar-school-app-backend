<?php

namespace Modules\CanteenManagement\Intents\MealPlan\UpdateMealPlan;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateMealPlanDTO extends Data
{
    public function __construct(
        // user
        public string $title,
        public ?string $description,
        public float $price,
        public int $quantity_available,
        public bool $is_active,
        // system
        public string $image_path,
        public int $updated_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'title' => [new Required, new StringType],
            'description' => [],
            'price' => [new Required, new Numeric, new Min(0)],
            'quantity_available' => [new Required, new IntegerType, new Min(0)],
            'is_active' => [new Required],
            // system
            'image_path' => [new Required, new StringType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
