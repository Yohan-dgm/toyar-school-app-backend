<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoice\CreateTermFeeInvoice;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateTermFeeInvoiceUserDTO extends Data
{
    public function __construct(
        // user
        public float $amount,
        public Date $date,
        public int $student_id,
        public float $discount_total,
        public ?float $service_charges_total,
        public ?string $order_notes,
        public ?string $office_notes,
        public ?int $grade_level_id,
        public ?array $term_fee_invoice_item_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],
        ];
    }
}
