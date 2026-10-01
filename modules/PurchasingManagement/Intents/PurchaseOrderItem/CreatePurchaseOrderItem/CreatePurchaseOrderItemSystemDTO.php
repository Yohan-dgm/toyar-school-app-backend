<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrderItem\CreatePurchaseOrderItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePurchaseOrderItemSystemDTO extends Data
{
    public function __construct(
        public ?float $ordered_quantity,
        public ?float $billed_quantity,
        public ?float $received_quantity,
        public ?bool $is_purchase_order_item_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
