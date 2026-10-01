<?php

namespace Modules\AccountManagement\Intents\ServiceBillItem\CreateServiceBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServiceBillItemDTO extends Data
{
    public function __construct(

        public int $service_item_id,
        public string $service_bill_id,
        public ?string $description,
        public float $quantity,

        // system
        public int $created_by,
        public int $rate_id,
        public float $rate,
        public float $subtotal,
        public float $total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'service_item_id' => [new Required],
            'service_bill_id' => [new Required],
            'description' => [new Required],
            'quantity' => [new Required],

            // system
            'created_by' => [new Required],
            'rate_id' => [new Required],
            'rate' => [new Required],
            'subtotal' => [new Required],
            'total' => [new Required],

        ];
    }
}
