<?php

namespace Modules\AccountManagement\Intents\PaymentPlan\CreatePaymentPlanStatus;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePaymentPlanStatusSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public int $status_changed_by_id,
        public bool $is_active,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'status_changed_by_id' => [new Required, new IntegerType],
            'created_by' => [new Required],
        ];
    }
}
