<?php

namespace Modules\AccountManagement\Intents\CashDepositItem\CreateCashDepositItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCashDepositItemDTO extends Data
{
    public function __construct(

        public int $cash_deposit_id,
        public int $receipt_voucher_id,
        public float $amount,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'cash_deposit_id' => [new Required],
            'receipt_voucher_id' => [new Required],
            'amount' => [new Required],

            // system
            'created_by' => [new Required],
        ];
    }
}
