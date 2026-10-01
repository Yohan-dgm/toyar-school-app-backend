<?php

namespace Modules\AccountManagement\Intents\SupplierBill\CreateSupplierBill;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSupplierBillDTO extends Data
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
        public mixed $serial_number_prefix,
        public mixed $serial_number_digits,
        public mixed $serial_number_current_year,
        public mixed $serial_number_financial_year,
        public mixed $serial_number_suffix,
        public mixed $serial_number,
        public mixed $is_supplier_bill_complete,
        public mixed $supplier_bill_status_id,
        public mixed $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],

            // system
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
