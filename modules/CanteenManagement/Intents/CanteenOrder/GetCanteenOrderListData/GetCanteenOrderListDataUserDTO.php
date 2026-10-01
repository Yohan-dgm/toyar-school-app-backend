<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\GetCanteenOrderListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCanteenOrderListDataUserDTO extends Data
{
    public function __construct(
        public ?string $search_phrase,
        public ?string $status,
        public ?string $order_date,
        public int $page_size,
        public int $page,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'search_phrase' => [],
            'status' => [],
            'order_date' => [],
            'page_size' => [new Required, new IntegerType],
            'page' => [new Required, new IntegerType],
        ];
    }
}
