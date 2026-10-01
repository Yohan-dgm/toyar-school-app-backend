<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrder\UpdatePurchaseOrder;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdatePurchaseOrderUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public Date $date,
        public int $supplier_id,
        public ?string $general_supplier_info,
        public ?string $order_notes,
        public ?string $office_notes,
        public array $purchase_order_item_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
        ];
    }
}
