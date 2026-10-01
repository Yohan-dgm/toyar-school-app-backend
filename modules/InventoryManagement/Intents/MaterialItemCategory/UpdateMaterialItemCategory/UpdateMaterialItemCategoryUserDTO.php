<?php

namespace Modules\InventoryManagement\Intents\MaterialItemCategory\UpdateMaterialItemCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateMaterialItemCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public int $material_item_type_id,
        public string $name,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
            'material_item_type_id' => [new Required],
            'name' => [new Required],
            // system
        ];
    }
}
