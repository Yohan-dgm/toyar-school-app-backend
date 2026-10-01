<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoiceItem\CreateTermFeeInvoiceItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateTermFeeInvoiceItemSystemDTO extends Data
{
    public function __construct(
        public ?float $ordered_quantity,
        public ?float $billed_quantity,
        public ?float $issued_quantity,
        public ?bool $is_term_fee_invoice_item_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
