<?php

namespace Modules\AccountManagement\Intents\IncomeNote\CreateIncomeNote;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateIncomeNoteUserDTO extends Data
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
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
