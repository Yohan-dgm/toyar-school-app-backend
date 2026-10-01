<?php

namespace Modules\AccountManagement\Intents\ExpenseParty\UpdateExpenseParty;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExpensePartyUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $name,
        public string $expense_party_type,
        public ?int $person_title_id,
        public string $phone,
        public ?string $email,
        public string $full_address,
        public int $country_id
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
        ];
    }
}
