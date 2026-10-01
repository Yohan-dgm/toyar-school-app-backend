<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateTermFeeInvoiceItemDTO extends Data
{
    public function __construct(
        public int $term_fee_invoice_id,
        public ?int $school_fee_id,
        public ?int $grade_level_id,
        public ?int $term_id,
        public ?float $item_total,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'term_fee_invoice_id' => [new Required],

            // system
            'created_by' => [new Required],

        ];
    }
}
