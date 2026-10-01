<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\GetTodayMealOrderSummary;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetTodayMealOrderSummaryUserDTO extends Data
{
    public function __construct(
        public ?string $date,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'date' => [],
        ];
    }
}
