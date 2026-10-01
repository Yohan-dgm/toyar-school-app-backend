<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemSubCategory\CreateCurrentAssetItemSubCategory;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCurrentAssetItemSubCategoryUserDTO extends Data
{
    public function __construct(
        // user
        public int $current_asset_item_category_id,
        public string $name,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType, new Unique('current_asset_item_sub_category', 'name')],
            'current_asset_item_category_id' => [new Required],
            // system
        ];
    }
}
