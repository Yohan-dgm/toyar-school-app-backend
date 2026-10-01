<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\UpdateCurrentAssetItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateCurrentAssetItemDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public int $current_asset_item_type_id,
        public int $current_asset_item_category_id,
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
            'current_asset_item_type_id' => [new Required],
            'current_asset_item_category_id' => [new Required],
            'unit_id' => [new Required],
            'reorder_level' => [new Required],

            // system
            'updated_by' => [new Required],
        ];
    }
}
