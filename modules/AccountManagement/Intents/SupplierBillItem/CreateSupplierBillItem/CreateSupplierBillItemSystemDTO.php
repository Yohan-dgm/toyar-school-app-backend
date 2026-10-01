<?php

namespace Modules\AccountManagement\Intents\SupplierBillItem\CreateSupplierBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSupplierBillItemSystemDTO extends Data
{
    public function __construct(
        // system
        public mixed $purchase_order_id,
        public mixed $is_supplier_bill_item_complete,
        public mixed $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
