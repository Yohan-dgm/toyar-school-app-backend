<?php

namespace Modules\AccountManagement\Intents\ItemRate\CreateItemRate;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateItemRateSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public int $status_changed_by_id,
        public int $version,
        public bool $is_active,
        public ?int $item_rate_status_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'status_changed_by_id' => [new Required, new IntegerType],
            'created_by' => [new Required],
            'version' => [new Required, new IntegerType],
            'is_active' => [new Required, new BooleanType],
        ];
    }
}
