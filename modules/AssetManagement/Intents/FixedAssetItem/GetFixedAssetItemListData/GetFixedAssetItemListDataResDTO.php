<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\GetFixedAssetItemListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetFixedAssetItemListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $fixed_asset_item_count,
        public ?object $fixed_asset_item_type_fixed_asset_item_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
