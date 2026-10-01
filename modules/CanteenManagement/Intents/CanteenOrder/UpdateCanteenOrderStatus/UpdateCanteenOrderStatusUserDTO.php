<?php

namespace Modules\CanteenManagement\Intents\CanteenOrder\UpdateCanteenOrderStatus;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateCanteenOrderStatusUserDTO extends Data
{
    public function __construct(
        public int $id,
        public string $status,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'id' => [new Required, new IntegerType],
            'status' => [new Required, 'in:Pending,Completed,Cancelled'],
        ];
    }
}
