<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrderItem\CreatePurchaseOrderItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePurchaseOrderItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $purchase_order_id,
        // public int $purchase_request_note_id,
        public ?string $item_type,
        public ?int $material_item_id,
        public ?float $item_quantity,
        public ?string $print_description,
        public ?float $print_quantity,
        public ?string $print_unit,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'purchase_order_id' => [new Required],
        ];
    }
}
