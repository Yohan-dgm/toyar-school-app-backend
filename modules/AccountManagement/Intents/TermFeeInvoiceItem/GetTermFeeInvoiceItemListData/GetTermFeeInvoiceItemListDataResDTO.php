<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoiceItem\GetTermFeeInvoiceItemListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetTermFeeInvoiceItemListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $term_fee_invoice_item_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
