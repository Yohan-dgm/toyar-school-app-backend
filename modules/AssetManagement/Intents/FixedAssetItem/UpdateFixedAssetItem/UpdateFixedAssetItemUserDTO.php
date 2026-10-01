<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\UpdateFixedAssetItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateFixedAssetItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $name,
        public int $fixed_asset_item_type_id,
        public int $fixed_asset_item_category_id,
        public int $unit_id,
        public float $reorder_level,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
            'name' => [new Required],
            'fixed_asset_item_type_id' => [new Required],
            'fixed_asset_item_category_id' => [new Required],
            'unit_id' => [new Required],
            'reorder_level' => [new Required],
            // system
        ];
    }
}
