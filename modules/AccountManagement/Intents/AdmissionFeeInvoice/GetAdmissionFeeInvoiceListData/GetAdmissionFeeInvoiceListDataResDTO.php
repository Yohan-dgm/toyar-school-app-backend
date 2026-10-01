<?php

namespace Modules\AccountManagement\Intents\AdmissionFeeInvoice\GetAdmissionFeeInvoiceListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetAdmissionFeeInvoiceListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $admission_fee_invoice_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
