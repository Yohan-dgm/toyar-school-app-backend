<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNote\UpdatePurchaseRequestNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdatePurchaseRequestNoteUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $item_type,
        public ?int $material_item_id,
        public ?string $service_item_description,
        public float $quantity,
        public ?string $requirement,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
            'item_type' => [new Required],
            'quantity' => [new Required],

            // system
        ];
    }
}
