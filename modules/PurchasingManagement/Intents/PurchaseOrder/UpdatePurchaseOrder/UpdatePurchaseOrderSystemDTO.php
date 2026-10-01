<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrder\UpdatePurchaseOrder;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdatePurchaseOrderSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
        public ?bool $is_purchase_order_complete,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
