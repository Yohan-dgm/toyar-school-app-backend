<?php

namespace Modules\InventoryManagement\Intents\MaterialItem\CreateMaterialItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMaterialItemDTO extends Data
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
        public int $created_by,
        public string $serial_number_prefix,
        public int $serial_number_digits,
        public int $serial_number_current_year,
        public ?string $serial_number_suffix,
        public string $serial_number,
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
            'created_by' => [new Required],
        ];
    }
}
