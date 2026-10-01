<?php

namespace Modules\AccountManagement\Intents\CashDeposit\GetCashDepositListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCashDepositListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $cash_deposit_count,
        public ?object $pending_attachment_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
