<?php

namespace Modules\ServiceManagement\Intents\ServiceItem\CreateServiceItem;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServiceItemDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public int $service_item_type_id,
        public int $service_item_category_id,
        public int $unit_id,
        public float $reorder_level,
        public bool $is_expirable,

        // system
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
            // user
            'name' => [new Required, new StringType],
            'service_item_type_id' => [new Required, new IntegerType],
            'service_item_category_id' => [new Required, new IntegerType],
            'unit_id' => [new Required, new IntegerType],
            'reorder_level' => [new Required],
            'is_expirable' => [new Required, new BooleanType],

            // system
            'created_by' => [new Required, new IntegerType],
            'serial_number_prefix' => [new Required, new StringType],
            'serial_number_digits' => [new Required, new IntegerType],
            'serial_number_current_year' => [new Required, new IntegerType],
            'serial_number_suffix' => [new IntegerType],
            'serial_number' => [new Required, new StringType],
        ];
    }
}
