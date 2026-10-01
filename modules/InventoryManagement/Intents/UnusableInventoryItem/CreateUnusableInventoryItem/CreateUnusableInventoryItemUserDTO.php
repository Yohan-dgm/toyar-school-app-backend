<?php

namespace Modules\InventoryManagement\Intents\UnusableInventoryItem\CreateUnusableInventoryItem;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateUnusableInventoryItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $inventory_item_id,
        public float $unusable_quantity,
        public string $unusable_reason,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'inventory_item_id' => [new Required, new IntegerType],
            'unusable_quantity' => [new Required],
            'unusable_reason' => [new Required],

        ];
    }
}
