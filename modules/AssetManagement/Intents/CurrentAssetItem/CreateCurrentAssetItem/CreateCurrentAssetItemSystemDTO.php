<?php

namespace Modules\AssetManagement\Intents\CurrentAssetItem\CreateCurrentAssetItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCurrentAssetItemSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public string $serial_number_prefix,
        public int $serial_number_digits,
        public int $serial_number_current_year,
        public ?string $serial_number_suffix,
        public string $serial_number,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
