<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\GetMyCanteenOrderListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetMyCanteenOrderListDataUserDTO extends Data
{
    public function __construct(
        public ?string $status,
        public int $page_size,
        public int $page,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'status' => [],
            'page_size' => [new Required, new IntegerType],
            'page' => [new Required, new IntegerType],
        ];
    }
}
