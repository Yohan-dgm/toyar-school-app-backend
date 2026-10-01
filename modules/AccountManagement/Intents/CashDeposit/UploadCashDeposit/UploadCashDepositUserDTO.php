<?php

namespace Modules\AccountManagement\Intents\CashDeposit\UploadCashDeposit;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UploadCashDepositUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public mixed $cash_deposit_slip_unsaved_attachment_list,
        public mixed $cash_deposit_slip_attachment_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
        ];
    }
}
