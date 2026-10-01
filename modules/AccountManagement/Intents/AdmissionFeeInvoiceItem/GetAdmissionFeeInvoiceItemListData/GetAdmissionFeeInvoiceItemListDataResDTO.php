<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoiceItem\GetAdmissionFeeInvoiceItemListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetAdmissionFeeInvoiceItemListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $admission_fee_invoice_item_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
