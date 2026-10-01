<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\CreateFixedAssetItemCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateFixedAssetItemCategoryDTO extends Data
{
    public function __construct(
        // user
        public int $fixed_asset_item_type_id,
        public string $name,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'fixed_asset_item_type_id' => [new Required],
            'name' => [new Required, new StringType, new Unique('fixed_asset_item_category', 'name')],
            // system
            'created_by' => [new Required],
        ];
    }
}
