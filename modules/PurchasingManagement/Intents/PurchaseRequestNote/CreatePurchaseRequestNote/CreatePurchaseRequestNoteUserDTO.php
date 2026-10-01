<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNote\CreatePurchaseRequestNote;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePurchaseRequestNoteUserDTO extends Data
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
        ];
    }
}
