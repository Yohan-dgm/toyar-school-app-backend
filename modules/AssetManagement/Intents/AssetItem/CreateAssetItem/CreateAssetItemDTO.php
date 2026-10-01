<?php

namespace Modules\AssetManagement\Intents\AssetItem\CreateAssetItem;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateAssetItemDTO extends Data
{
    public function __construct(
        // user
        public string $asset_type,
        public ?int $fixed_asset_item_id,
        public ?int $current_asset_item_id,
        public int $goods_received_note_id,
        public date $received_date,
        public float $received_quantity,
        public float $current_quantity,
        public float $unit_price,
        public float $landed_rate,
        public float $landed_value,
        public bool $is_unusable,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [

            // user
            'asset_type' => [new Required, new StringType],
            'goods_received_note_id' => [new Required, new IntegerType],
            'received_date' => [new Required, new Date],
            'received_quantity' => [new Required],
            'current_quantity' => [new Required],
            'unit_price' => [new Required],
            'landed_rate' => [new Required],
            'landed_value' => [new Required],
            'is_unusable' => [new Required],

            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
