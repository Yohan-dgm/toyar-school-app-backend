<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\UpdateFixedAssetItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateFixedAssetItemDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public int $fixed_asset_item_type_id,
        public int $fixed_asset_item_category_id,
        public int $unit_id,
        public float $reorder_level,

        // system
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required],
            'fixed_asset_item_type_id' => [new Required],
            'fixed_asset_item_category_id' => [new Required],
            'unit_id' => [new Required],
            'reorder_level' => [new Required],

            // system
            'updated_by' => [new Required],
        ];
    }
}
