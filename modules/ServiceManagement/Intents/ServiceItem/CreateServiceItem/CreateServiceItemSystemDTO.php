<?php

namespace Modules\ServiceManagement\Intents\ServiceItem\CreateServiceItem;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServiceItemSystemDTO extends Data
{
    public function __construct(
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

            // system
            'created_by' => [new Required, new IntegerType],
            'serial_number_prefix' => [new Required, new StringType],
            'serial_number_digits' => [new Required, new IntegerType],
            'serial_number_current_year' => [new Required, new IntegerType],
            'serial_number_suffix' => [new IntegerType],
            'serial_number' => [new Required, new StringType, new Unique('service_item', 'serial_number')],
        ];
    }
}
