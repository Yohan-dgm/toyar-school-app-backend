<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\UpdateFixedAssetItemCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateFixedAssetItemCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public int $fixed_asset_item_type_id,
        public string $name,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
            'fixed_asset_item_type_id' => [new Required],
            'name' => [new Required],
            // system
        ];
    }
}
