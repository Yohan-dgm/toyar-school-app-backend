<?php

namespace Modules\ServiceManagement\Intents\ServiceItem\CreateServiceItem;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServiceItemUserDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public int $service_item_type_id,
        public int $service_item_category_id,
        public int $unit_id,
        public float $reorder_level,
        public bool $is_expirable,
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

        ];
    }
}
