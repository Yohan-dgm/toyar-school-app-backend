<?php

namespace Modules\InventoryManagement\Intents\MaterialItem\GetMaterialItemListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetMaterialItemListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $material_item_count,
        public ?object $material_item_type_material_item_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
