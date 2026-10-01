<?php

namespace Modules\AccountManagement\Intents\SupplierBill\UpdateSupplierBill;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSupplierBillSystemDTO extends Data
{
    public function __construct(
        public mixed $is_supplier_bill_complete,
        public mixed $supplier_bill_status_id,
        public mixed $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
