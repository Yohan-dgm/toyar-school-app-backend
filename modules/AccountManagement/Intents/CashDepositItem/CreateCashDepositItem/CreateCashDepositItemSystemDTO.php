<?php

namespace Modules\AccountManagement\Intents\CashDepositItem\CreateCashDepositItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCashDepositItemSystemDTO extends Data
{
    public function __construct(
        public int $created_by,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // system
            'created_by' => [new Required],
        ];
    }
}
