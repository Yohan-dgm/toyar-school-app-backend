<?php

namespace Modules\AccountManagement\Intents\ItemRateStatus\CreateItemRateStatus;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateItemRateStatusSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public int $status_changed_by_id,
        public bool $is_active,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
            'status_changed_by_id' => [new Required, new IntegerType],
            'is_active' => [new Required, new BooleanType],
        ];
    }
}
