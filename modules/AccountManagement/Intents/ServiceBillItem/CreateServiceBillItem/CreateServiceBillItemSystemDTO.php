<?php

namespace Modules\AccountManagement\Intents\ServiceBillItem\CreateServiceBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServiceBillItemSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public int $rate_id,
        public float $rate,
        public float $subtotal,
        public float $total,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
            'rate_id' => [new Required],
            'rate' => [new Required],
            'subtotal' => [new Required],
            'total' => [new Required],
        ];
    }
}
