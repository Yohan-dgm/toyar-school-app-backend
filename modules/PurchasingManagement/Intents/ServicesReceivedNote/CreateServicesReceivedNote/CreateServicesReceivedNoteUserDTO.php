<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNote\CreateServicesReceivedNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServicesReceivedNoteUserDTO extends Data
{
    public function __construct(
        // user
        public mixed $purchase_order_id,
        public mixed $date,
        public mixed $reference_number,
        public mixed $office_notes,
        public mixed $services_received_note_item_list,
        public mixed $services_received_note_unsaved_attachment_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],
        ];
    }
}
