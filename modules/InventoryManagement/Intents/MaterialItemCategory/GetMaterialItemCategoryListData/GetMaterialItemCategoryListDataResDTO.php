<?php

namespace Modules\InventoryManagement\Intents\MaterialItemCategory\GetMaterialItemCategoryListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetMaterialItemCategoryListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $material_item_category_count,
        public ?object $material_item_type_category_list_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
