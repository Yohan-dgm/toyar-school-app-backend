<?php

namespace Modules\AccountManagement\Intents\SupplierBillItem\CreateSupplierBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSupplierBillItemDTO extends Data
{
    public function __construct(
        // user
        public mixed $supplier_bill_id,
        public mixed $item_type,
        public mixed $purchase_order_item_id,
        public mixed $ordered_quantity,
        public mixed $item_unit,
        public mixed $unit_price,
        public mixed $billed_quantity,
        public mixed $item_total,
        // system
        public mixed $purchase_order_id,
        public mixed $is_supplier_bill_item_complete,
        public mixed $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'supplier_bill_id' => [new Required],

            // system
            'created_by' => [new Required],

        ];
    }
}
