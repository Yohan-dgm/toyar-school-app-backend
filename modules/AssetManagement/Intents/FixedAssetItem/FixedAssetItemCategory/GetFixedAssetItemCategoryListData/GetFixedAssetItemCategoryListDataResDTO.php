<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemCategory\GetFixedAssetItemCategoryListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetFixedAssetItemCategoryListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $fixed_asset_item_category_count,
        public ?object $fixed_asset_item_type_category_list_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
