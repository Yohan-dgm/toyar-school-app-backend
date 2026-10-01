<?php

namespace Modules\AccountManagement\Intents\PaymentPlan\CreatePaymentPlan;

use PhpParser\Node\Expr\Cast\Double;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePaymentPlanUserDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public int $grade_level_id,
        public int $main_program_id,
        public Double $main_program_down_payment,
        public Double $admission_down_payment,
        public Double $refundable_deposit_down_payment,
        public Double $discount,
        public int $agreed_number_of_installments,
        public bool $should_add_installment_interest,
        public ?Double $installment_interest_factor,
        public ?bool $should_add_late_payment_interest,
        public Double $late_payment_interest_factor,
        public ?array $payment_plan_item,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
        ];
    }
}
