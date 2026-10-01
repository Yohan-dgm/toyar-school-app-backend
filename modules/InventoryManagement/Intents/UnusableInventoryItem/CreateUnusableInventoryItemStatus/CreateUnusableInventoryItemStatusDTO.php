<?php

namespace Modules\InventoryManagement\Intents\UnusableInventoryItem\CreateUnusableInventoryItemStatus;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateUnusableInventoryItemStatusDTO extends Data
{
    public function __construct(
        // user
        public ?int $id,

        // system
        public ?int $updated_by,
        public ?int $unusable_inventory_item_status_type_id,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],

            // system
            'updated_by' => [new Required],
            'unusable_inventory_item_status_type_id' => [new Required],

        ];
    }
}
