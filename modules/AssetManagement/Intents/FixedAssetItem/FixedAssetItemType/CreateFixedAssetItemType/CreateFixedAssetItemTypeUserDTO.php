<?php

namespace Modules\AssetManagement\Intents\FixedAssetItem\FixedAssetItemType\CreateFixedAssetItemType;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateFixedAssetItemTypeUserDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required],
            // system
        ];
    }
}
