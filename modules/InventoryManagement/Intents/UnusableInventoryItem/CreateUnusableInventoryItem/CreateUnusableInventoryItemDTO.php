<?php

namespace Modules\InventoryManagement\Intents\UnusableInventoryItem\CreateUnusableInventoryItem;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateUnusableInventoryItemDTO extends Data
{
    public function __construct(
        // user
        public int $inventory_item_id,
        public float $unusable_quantity,
        public string $unusable_reason,

        // system
        public int $created_by,
        public Date $unusable_marked_date,
        public int $unusable_marked_by,
        public int $unusable_inventory_item_status_type_id
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'inventory_item_id' => [new Required, new IntegerType],
            'unusable_quantity' => [new Required],
            'unusable_reason' => [new Required],

            // system
            'created_by' => [new Required, new IntegerType],
            'unusable_marked_date' => [new Required],
            'unusable_marked_by' => [new Required],
            'unusable_inventory_item_status_type_id' => [new Required],
        ];
    }
}
