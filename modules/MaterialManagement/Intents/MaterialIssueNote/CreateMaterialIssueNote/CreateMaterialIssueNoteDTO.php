<?php

namespace Modules\MaterialManagement\Intents\MaterialIssueNote\CreateMaterialIssueNote;

use Ramsey\Uuid\Type\Decimal;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMaterialIssueNoteDTO extends Data
{
    public function __construct(
        // user
        public ?int $material_request_note_id,
        public ?string $issued_date,
        public ?int $issued_by,
        public ?int $received_by,
        public ?int $received_department_id,
        public ?Decimal $quantity,
        public ?string $purpose,
        public ?int $status_changed_by,
        public ?int $material_issue_note_status_id,

        // system
        public int $created_by,
        public ?int $updated_by,
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
            'material_request_note_id' => [new Required],
            'issued_date' => [new Required],
            'issued_by' => [new Required],
            'received_by_id' => [new Required],
            'received_department_id' => [new Required],
            'quantity' => [new Required],
            'purpose' => [new Required],
            'material_issue_note_status_id' => [new Required],

            // system
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
