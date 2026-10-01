<?php

namespace Modules\AccountManagement\Intents\PaymentPlan\CreatePaymentPlanStatus;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePaymentPlanStatusUserDTO extends Data
{
    public function __construct(
        // user
        public int $payment_plan_id,
        public int $payment_plan_status_type_id,
        public ?string $notes,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'payment_plan_id' => [new Required, new IntegerType],
            'payment_plan_status_type_id' => [new Required, new IntegerType],
            'notes' => [new StringType],
        ];
    }
}
