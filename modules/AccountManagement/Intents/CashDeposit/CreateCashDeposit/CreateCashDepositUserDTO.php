<?php

namespace Modules\AccountManagement\Intents\CashDeposit\CreateCashDeposit;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCashDepositUserDTO extends Data
{
    public function __construct(
        // user
        public int $bank_account_id,
        public Date $cash_deposit_date,
        public array $receipt_voucher_list,
        public float $total_amount,
        public string $received_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'cash_deposit_date' => [new Required],
            'bank_account_id' => [new Required],
            'total_amount' => [new Required],
            'received_by' => [new Required],
        ];
    }
}
