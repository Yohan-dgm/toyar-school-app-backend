<?php

namespace Modules\MaterialManagement\Intents\MaterialRequestNote\CreateMaterialRequestNote;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMaterialRequestNoteDTO extends Data
{
    public function __construct(
        // user
        public ?string $requested_date,
        public ?int $requested_department_id,
        public ?int $requested_by,
        public ?string $purpose,
        public ?int $material_request_note_status_id,
        public ?int $status_changed_by,

        // public ?array $inventory_item_list,

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
            'requested_date' => [new Required],
            'requested_department_id' => [new Required],
            'requested_by' => [new Required],
            'purpose' => [new Required],
            'material_request_note_status_id' => [new Required],

            // 'inventory_item_list' => [new Required(), new ArrayType(), new Min(1)],

            // system
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
