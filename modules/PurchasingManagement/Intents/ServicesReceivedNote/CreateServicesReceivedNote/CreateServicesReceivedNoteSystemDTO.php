<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNote\CreateServicesReceivedNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServicesReceivedNoteSystemDTO extends Data
{
    public function __construct(
        // system
        public mixed $serial_number_prefix,
        public mixed $serial_number_digits,
        public mixed $serial_number_current_year,
        public mixed $serial_number_financial_year,
        public mixed $serial_number_suffix,
        public mixed $serial_number,
        public mixed $is_services_received_note_complete,
        public mixed $services_received_note_status_id,
        public mixed $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
