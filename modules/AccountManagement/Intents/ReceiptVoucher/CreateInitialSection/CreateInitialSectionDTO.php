<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\CreateInitialSection;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateInitialSectionDTO extends Data
{
    public function __construct(
        // user
        public ?string $receipt_party,
        public ?int $student_id,
        public ?int $applicant_id,
        public ?string $narration,
        public ?string $amount,
        public ?string $payment_method,
        public ?int $bank_account_id,
        public ?string $bank_deposit_date,
        public ?int $cash_account_id,
        public ?string $cash_received_date,
        public ?string $check_type,
        public ?int $check_bank_id,
        public ?string $check_number,
        public ?string $check_received_date,
        public ?string $check_date,
        public ?int $payment_received_by_id,
        // system
        public string $payment_received_date,
        public string $serial_number_prefix,
        public int $serial_number_digits,
        public int $serial_number_current_year,
        public string $serial_number_financial_year,
        public string $serial_number_suffix,
        public string $serial_number,
        public int $receipt_voucher_status_type_id,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            // system
        ];
    }
}
