<?php

namespace Modules\AccountManagement\Intents\ExpenseParty\UpdateExpenseParty;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExpensePartyDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public string $expense_party_type,
        public ?int $person_title_id,
        public string $phone,
        public ?string $email,
        public string $full_address,
        public int $country_id,

        // system
        public int $updated_by,
        public ?string $name_with_title,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required],
            'expense_party_type' => [new Required],
            'phone' => [new Required],
            'full_address' => [new Required],
            'country_id' => [new Required],

            // system
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
