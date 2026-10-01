<?php

namespace Modules\InventoryManagement\Intents\UnusableInventoryItem\CreateUnusableInventoryItem;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateUnusableInventoryItemSystemDTO extends Data
{
    public function __construct(
        // system
        public int $created_by,
        public Date $unusable_marked_date,
        public int $unusable_marked_by,
        public int $unusable_inventory_item_status_type_id

    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'created_by' => [new Required, new IntegerType],
            'unusable_marked_date' => [new Required],
            'unusable_marked_by' => [new Required],
            'unusable_inventory_item_status_type_id' => [new Required],
        ];
    }
}
