<?php

namespace Modules\AccountManagement\Intents\SupplierBill\UpdateSupplierBill;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSupplierBillDTO extends Data
{
    public function __construct(
        // user
        public mixed $purchase_order_id,
        public mixed $date,
        public mixed $bill_reference_number,
        public mixed $items_total,
        public mixed $transport_charges_total,
        public mixed $service_charges_total,
        public mixed $subtotal_before_discount,
        public mixed $discount_total,
        public mixed $subtotal_after_discount,
        public mixed $tax_total,
        public mixed $bill_total,
        public mixed $office_notes,
        // system
        public mixed $is_supplier_bill_complete,
        public mixed $supplier_bill_status_id,
        public mixed $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
            'updated_by' => [new Required],
        ];
    }
}
