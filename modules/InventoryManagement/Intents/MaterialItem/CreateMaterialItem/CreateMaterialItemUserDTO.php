<?php

namespace Modules\InventoryManagement\Intents\MaterialItem\CreateMaterialItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMaterialItemUserDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public int $material_item_type_id,
        public int $material_item_category_id,
        public int $unit_id,
        public float $unit_price,
        public float $reorder_level,
        public bool $is_expirable,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required],
            'material_item_type_id' => [new Required],
            'material_item_category_id' => [new Required],
            'unit_id' => [new Required],
            'reorder_level' => [new Required],
            'is_expirable' => [new Required],
            // system
        ];
    }
}
