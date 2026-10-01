<?php

namespace Modules\AccountManagement\Intents\ServiceBillItem\CreateServiceBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServiceBillItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $service_item_id,
        public string $service_bill_id,
        public ?string $description,
        public float $quantity,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            'service_item_id' => [new Required],
            'service_bill_id' => [new Required],
            'description' => [new Required],
            'quantity' => [new Required],
        ];
    }
}
