<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CurrentAssetItemType\GetCurrentAssetItemTypeListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCurrentAssetItemTypeListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $current_asset_item_type_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
