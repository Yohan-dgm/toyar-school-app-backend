<?php

namespace Modules\AccountManagement\Intents\ItemRateStatus\CreateItemRateStatus;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateItemRateStatusUserDTO extends Data
{
    public function __construct(
        // user
        public int $item_rate_id,
        public int $item_rate_status_type_id,
        public ?string $notes,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'item_rate_id' => [new Required, new IntegerType],
            'item_rate_status_type_id' => [new Required, new IntegerType],
            'notes' => [new StringType],
        ];
    }
}
