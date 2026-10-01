<?php

namespace Modules\PurchasingManagement\Intents\PurchaseOrder\CreatePurchaseOrder;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePurchaseOrderSystemDTO extends Data
{
    public function __construct(
        public ?string $serial_number_prefix,
        public ?int $serial_number_digits,
        public ?string $serial_number_current_year,
        public ?string $serial_number_financial_year,
        public ?string $serial_number_suffix,
        public ?string $serial_number,
        public ?bool $is_purchase_order_complete,
        public ?int $purchase_order_status_id,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
