<?php

namespace Modules\InventoryManagement\Intents\MaterialItemSubCategory\CreateMaterialItemSubCategory;

use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMaterialItemSubCategoryDTO extends Data
{
    public function __construct(
        // user
        public int $material_item_category_id,
        public string $name,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType, new Unique('material_item_sub_category', 'name')],
            'material_item_category_id' => [new Required],

            // system
            'created_by' => [new Required],
        ];
    }
}
