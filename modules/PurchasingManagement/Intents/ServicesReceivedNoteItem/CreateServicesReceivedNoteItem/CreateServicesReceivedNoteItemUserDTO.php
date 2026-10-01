<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNoteItem\CreateServicesReceivedNoteItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServicesReceivedNoteItemUserDTO extends Data
{
    public function __construct(
        // user
        public mixed $services_received_note_id,
        public mixed $purchase_order_item_id,
        public mixed $ordered_quantity,
        public mixed $item_unit,
        public mixed $received_quantity,
        public mixed $received_by_id,
        public mixed $shelf_life_start_date,
        public mixed $shelf_life_end_date,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'services_received_note_id' => [new Required],
        ];
    }
}
