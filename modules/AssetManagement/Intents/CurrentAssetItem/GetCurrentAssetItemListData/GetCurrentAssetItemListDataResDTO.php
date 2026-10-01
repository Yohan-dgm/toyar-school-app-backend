<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\GetCurrentAssetItemListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCurrentAssetItemListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $current_asset_item_count,
        public ?object $current_asset_item_type_current_asset_item_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
