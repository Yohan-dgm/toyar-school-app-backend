<?php

namespace Modules\AccountManagement\Intents\ServiceBill\CreateServiceBill;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServiceBillDTO extends Data
{
    public function __construct(

        public Date $date,
        public string $bill_party,
        public ?int $student_id,
        public ?int $applicant_id,
        public ?array $service_bill_item_list,

        // system
        public int $created_by,
        public float $subtotal,
        public ?string $serial_number_prefix,
        public ?int $serial_number_digits,
        public ?string $serial_number_current_year,
        public ?string $serial_number_financial_year,
        public ?string $serial_number_suffix,
        public ?string $serial_number
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],
            'bill_party' => [new Required],

            // system
            'created_by' => [new Required],
            'serial_number' => [new Required],
            'subtotal' => [new Required],
            'total' => [new Required],

        ];
    }
}
