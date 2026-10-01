<?php

namespace Modules\AccountManagement\Intents\CashDeposit\CreateCashDeposit;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCashDepositSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public ?string $serial_number_prefix,
        public ?int $serial_number_digits,
        public ?string $serial_number_current_year,
        public ?string $serial_number_financial_year,
        public ?string $serial_number_suffix,
        public ?string $serial_number,
        public ?bool $is_attached

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // system
            'created_by' => [new Required],
            'serial_number' => [new Required],
        ];
    }
}
