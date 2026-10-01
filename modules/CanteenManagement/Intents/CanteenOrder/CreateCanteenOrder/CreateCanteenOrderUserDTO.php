<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\CreateCanteenOrder;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCanteenOrderUserDTO extends Data
{
    public function __construct(
        public int $student_id,
        public string $order_date,
        /** @var array<int, array{meal_plan_id: int, quantity: int}> */
        public array $items,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'student_id' => [new Required, new IntegerType],
            'order_date' => [new Required, new Date],
            'items' => [new Required, new ArrayType, new Min(1)],
            'items.*.meal_plan_id' => [new Required, new IntegerType],
            'items.*.quantity' => [new Required, new IntegerType, new Min(1)],
        ];
    }
}
