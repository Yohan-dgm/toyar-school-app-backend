<?php

namespace Modules\AccountManagement\Intents\IncomeNote\CreateIncomeNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateIncomeNoteDTO extends Data
{
    public function __construct(
        // user
        public mixed $date,
        public mixed $income_party_id,
        public mixed $general_income_party_info,
        public mixed $income_type_id,
        public mixed $income_category_id,
        public mixed $amount,
        public mixed $office_notes,

        // system
        public mixed $serial_number_prefix,
        public mixed $serial_number_digits,
        public mixed $serial_number_current_year,
        public mixed $serial_number_financial_year,
        public mixed $serial_number_suffix,
        public mixed $serial_number,
        public mixed $is_income_note_complete,
        public mixed $income_note_status_id,
        public mixed $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
            'created_by' => [new Required],
        ];
    }
}
