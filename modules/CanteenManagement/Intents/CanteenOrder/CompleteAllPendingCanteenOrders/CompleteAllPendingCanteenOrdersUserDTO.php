<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\CompleteAllPendingCanteenOrders;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CompleteAllPendingCanteenOrdersUserDTO extends Data
{
    public function __construct(
        public ?string $search_phrase,
        public ?string $order_date,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'search_phrase' => [],
            'order_date' => [],
        ];
    }
}
