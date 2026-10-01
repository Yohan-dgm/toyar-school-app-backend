<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemSubCategory\GetCurrentAssetItemSubCategoryListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCurrentAssetItemSubCategoryListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $current_asset_item_sub_category_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
