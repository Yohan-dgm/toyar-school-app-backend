<?php

namespace Modules\CanteenManagement\Intents\MealPlan\DeleteMealPlan;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class DeleteMealPlanUserDTO extends Data
{
    public function __construct(
        public int $id,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'id' => [new Required, new IntegerType],
        ];
    }
}
