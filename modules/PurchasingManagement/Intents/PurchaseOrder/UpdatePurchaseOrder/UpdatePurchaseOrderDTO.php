<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrder\UpdatePurchaseOrder;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdatePurchaseOrderDTO extends Data
{
    public function __construct(
        public Date $date,
        public int $supplier_id,
        public ?string $general_supplier_info,
        public ?string $order_notes,
        public ?string $office_notes,

        // system
        public int $updated_by,
        public ?bool $is_purchase_order_complete,
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
