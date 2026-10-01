<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemCategory\GetCurrentAssetItemCategoryListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCurrentAssetItemCategoryListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $current_asset_item_category_count,
        public ?object $current_asset_item_type_category_list_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
