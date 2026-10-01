<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemSubCategory\CreateFixedAssetItemSubCategory;

use Illuminate\Validation\Rules\Unique;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateFixedAssetItemSubCategoryDTO extends Data
{
    public function __construct(
        // user
        public int $fixed_asset_item_category_id,
        public string $name,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType, new Unique('fixed_asset_item_sub_category', 'name')],
            'fixed_asset_item_category_id' => [new Required],

            // system
            'created_by' => [new Required],
        ];
    }
}
