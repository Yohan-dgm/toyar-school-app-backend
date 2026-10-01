<?php

namespace Modules\AccountManagement\Intents\ServiceBill\GetServiceBillListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetServiceBillListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $service_bill_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
