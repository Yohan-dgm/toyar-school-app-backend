<?php

namespace Modules\AccountManagement\Intents\IncomeParty\CreateIncomeParty;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateIncomePartyDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public string $income_party_type,
        public ?int $person_title_id,
        public string $phone,
        public ?string $email,
        public string $full_address,
        public int $country_id,

        // system
        public int $created_by,
        public ?int $updated_by,
        public ?string $name_with_title,
        public ?string $serial_number_prefix,
        public ?int $serial_number_digits,
        public ?string $serial_number_current_year,
        public ?string $serial_number_financial_year,
        public ?string $serial_number_suffix,
        public string $serial_number,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required],
            'income_party_type' => [new Required],
            'phone' => [new Required],
            'full_address' => [new Required],
            'country_id' => [new Required],

            // system
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
