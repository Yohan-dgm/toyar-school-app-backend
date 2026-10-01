<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoice\CreateAdmissionFeeInvoice;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateAdmissionFeeInvoiceSystemDTO extends Data
{
    public function __construct(
        public ?string $serial_number_prefix,
        public ?int $serial_number_digits,
        public ?string $serial_number_current_year,
        public ?string $serial_number_financial_year,
        public ?string $serial_number_suffix,
        public ?string $serial_number,
        public ?bool $is_admission_fee_invoice_complete,
        public ?int $admission_fee_invoice_status_id,
        public int $created_by,
        public ?float $items_total,
        public ?float $subtotal_before_discount,
        public ?float $subtotal_after_discount,
        public float $bill_total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
