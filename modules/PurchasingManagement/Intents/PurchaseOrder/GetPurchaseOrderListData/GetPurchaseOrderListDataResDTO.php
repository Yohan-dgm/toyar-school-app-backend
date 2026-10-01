<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrder\GetPurchaseOrderListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetPurchaseOrderListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $purchase_order_count,
        public ?object $due_payment_order_count,
        public ?object $payment_completed_order_count,
        public ?object $payment_due_invoice_total_amount,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
