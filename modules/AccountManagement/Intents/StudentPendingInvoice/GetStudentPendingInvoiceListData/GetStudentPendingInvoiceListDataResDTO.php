<?php

namespace Modules\AccountManagement\Intents\StudentPendingInvoice\GetStudentPendingInvoiceListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentPendingInvoiceListDataResDTO extends Data
{
    public function __construct(
        // user
        public ?array $pending_invoices,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
