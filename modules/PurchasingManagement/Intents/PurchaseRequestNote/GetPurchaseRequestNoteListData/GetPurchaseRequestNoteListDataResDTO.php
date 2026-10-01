<?php

namespace Modules\PurchasingManagement\Intents\PurchaseRequestNote\GetPurchaseRequestNoteListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetPurchaseRequestNoteListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $purchase_request_note_count,
        public ?object $purchase_request_note_status_type_purchase_request_note_status_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
