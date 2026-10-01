<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateTermFeeInvoiceItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $term_fee_invoice_id,
        public ?int $school_fee_id,
        public ?int $grade_level_id,
        public ?int $term_id,
        public ?float $item_total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'term_fee_invoice_id' => [new Required],
        ];
    }
}
