<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNoteStatus\CreatePurchaseRequestNoteStatus;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePurchaseRequestNoteStatusUserDTO extends Data
{
    public function __construct(
        // user
        public int $purchase_request_note_id,
        public int $purchase_request_note_status_type_id,
        public mixed $notes,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'purchase_request_note_id' => [new Required, new IntegerType],
            'purchase_request_note_status_type_id' => [new Required, new IntegerType],
        ];
    }
}
