<?php

namespace Modules\AccountManagement\Intents\ServiceBill\CreateServiceBill;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateServiceBillUserDTO extends Data
{
    public function __construct(
        // user
        public Date $date,
        public string $bill_party,
        public ?int $student_id,
        public ?int $applicant_id,
        public ?array $service_bill_item_list

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],
            'bill_party' => [new Required],
        ];
    }
}
