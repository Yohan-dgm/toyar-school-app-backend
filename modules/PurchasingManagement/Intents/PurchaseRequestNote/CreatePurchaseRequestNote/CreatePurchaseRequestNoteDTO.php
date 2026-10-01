<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNote\CreatePurchaseRequestNote;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePurchaseRequestNoteDTO extends Data
{
    public function __construct(
        // user
        public string $item_type,
        public ?int $material_item_id,
        public ?string $service_item_description,
        public date $date,
        public float $quantity,
        public int $requested_by_id,
        public ?string $requirement,

        // system
        public ?int $purchase_request_note_status_id,
        public int $created_by,
        public string $serial_number_prefix,
        public int $serial_number_digits,
        public string $serial_number_current_year,
        public string $serial_number_financial_year,
        public ?string $serial_number_suffix,
        public string $serial_number,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'item_type' => [new Required],
            'date' => [new Required],
            'quantity' => [new Required],
            'requested_by_id' => [new Required],

            // system
            'created_by' => [new Required],
            'serial_number' => [new Required],

        ];
    }
}
