<?php

namespace Modules\InventoryManagement\Intents\MaterialItemType\GetMaterialItemTypeListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetMaterialItemTypeListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $material_item_type_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
