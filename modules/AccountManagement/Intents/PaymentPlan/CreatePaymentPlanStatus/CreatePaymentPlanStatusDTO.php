<?php

namespace Modules\AccountManagement\Intents\PaymentPlan\CreatePaymentPlanStatus;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePaymentPlanStatusDTO extends Data
{
    public function __construct(

        public int $payment_plan_id,
        public int $payment_plan_status_type_id,
        public ?string $notes,
        // system
        public int $created_by,
        public int $status_changed_by_id,
        public bool $is_active,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'payment_plan_id' => [new Required, new IntegerType],
            'payment_plan_status_type_id' => [new Required, new IntegerType],
            'notes' => [new StringType],

            // system
            'status_changed_by_id' => [new Required, new IntegerType],
            'created_by' => [new Required],

        ];
    }
}
