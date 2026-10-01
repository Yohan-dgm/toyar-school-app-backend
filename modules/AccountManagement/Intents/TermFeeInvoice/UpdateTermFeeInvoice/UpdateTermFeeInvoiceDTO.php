<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoice\UpdateTermFeeInvoice;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateTermFeeInvoiceDTO extends Data
{
    public function __construct(
        public Date $date,
        public int $student_id,
        public ?float $items_total,
        public ?float $service_charges_total,
        public ?float $subtotal_before_discount,
        public ?float $discount_total,
        public ?float $subtotal_after_discount,
        public ?float $bill_total,
        public ?string $order_notes,
        public ?string $office_notes,
        public ?int $term_id,

        // system
        public int $updated_by,
        public ?bool $is_term_fee_invoice_complete,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
            'updated_by' => [new Required],
        ];
    }
}
