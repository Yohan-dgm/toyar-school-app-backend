<?php

namespace Modules\PurchasingManagement\Intents\ServicesReceivedNote\UpdateServicesReceivedNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateServicesReceivedNoteSystemDTO extends Data
{
    public function __construct(
        public mixed $is_services_received_note_complete,
        public mixed $services_received_note_status_id,
        public mixed $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
