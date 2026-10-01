<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoice\CreateSportFeeInvoice;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSportFeeInvoiceUserDTO extends Data
{
    public function __construct(
        // user
        public Date $date,
        public int $student_id,
        public ?float $items_total,
        public ?float $service_charges_total,
        public ?float $subtotal_before_discount,
        public ?float $discount_total,
        public ?float $subtotal_after_discount,
        public ?float $tax_total,
        public ?float $bill_total,
        public ?string $order_notes,
        public ?string $office_notes,
        public array $sport_fee_invoice_item_list,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],
        ];
    }
}
