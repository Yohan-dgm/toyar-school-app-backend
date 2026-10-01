<?php

namespace Modules\AccountManagement\Intents\IncomeNote\UpdateIncomeNote;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateIncomeNoteUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
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
            'id' => [new Required],
            // system
        ];
    }
}
