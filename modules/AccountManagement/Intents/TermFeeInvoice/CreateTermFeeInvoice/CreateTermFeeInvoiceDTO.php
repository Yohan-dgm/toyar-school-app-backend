<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoice\CreateTermFeeInvoice;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateTermFeeInvoiceDTO extends Data
{
    public function __construct(
        // user
        public ?float $amount,
        public Date $date,
        public int $student_id,
        public float $discount_total,
        public ?float $service_charges_total,
        public ?string $order_notes,
        public ?string $office_notes,

        // system
        public ?string $serial_number_prefix,
        public ?int $serial_number_digits,
        public ?string $serial_number_current_year,
        public ?string $serial_number_financial_year,
        public ?string $serial_number_suffix,
        public ?string $serial_number,
        public ?int $term_id,

        public ?float $items_total,
        public ?float $subtotal_before_discount,
        public ?float $subtotal_after_discount,
        public float $bill_total,
        public ?bool $is_term_fee_invoice_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],

            // system
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
