<?php

namespace Modules\AccountManagement\Intents\CashDeposit\UploadCashDeposit;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UploadCashDepositDTO extends Data
{
    public function __construct(

        public int $bank_account_id,
        public Date $cash_deposit_date,
        public float $total_amount,
        public string $received_by,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
            'created_by' => [new Required],
        ];
    }
}
