<?php

namespace Modules\AccountManagement\Intents\CashDepositItem\CreateCashDepositItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCashDepositItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $cash_deposit_id,
        public int $receipt_voucher_id,
        public float $amount,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'cash_deposit_id' => [new Required],
            'receipt_voucher_id' => [new Required],
            'amount' => [new Required],
        ];
    }
}
