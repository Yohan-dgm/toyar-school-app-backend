<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrderItem\CreatePurchaseOrderItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePurchaseOrderItemDTO extends Data
{
    public function __construct(
        public int $purchase_order_id,
        // public int $purchase_request_note_id,
        public ?string $item_type,
        public ?int $material_item_id,
        public ?float $item_quantity,
        public ?string $print_description,
        public ?float $print_quantity,
        public ?string $print_unit,

        // system
        public ?float $ordered_quantity,
        public ?float $billed_quantity,
        public ?float $received_quantity,
        public ?bool $is_purchase_order_item_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'purchase_order_id' => [new Required],

            // system
            'created_by' => [new Required],

        ];
    }
}
