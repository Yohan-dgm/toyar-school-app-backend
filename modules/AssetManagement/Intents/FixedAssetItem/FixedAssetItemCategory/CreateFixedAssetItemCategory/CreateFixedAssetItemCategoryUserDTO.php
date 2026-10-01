<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\CreateFixedAssetItemCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateFixedAssetItemCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public int $fixed_asset_item_type_id,
        public string $name,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'fixed_asset_item_type_id' => [new Required],
            'name' => [new Required],
            // system
        ];
    }
}
