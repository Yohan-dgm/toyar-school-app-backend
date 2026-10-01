<?php

namespace Modules\AccountManagement\Intents\ReceivableDashboard\GetReceivableDashboardListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetReceivableDashboardListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        // public ?object $approved_admission_fee_sum,
        // public ?object $admission_fee_settlement_sum,
        // public ?object $applicable_refundable_deposit_sum,
        // public ?object $refundable_deposit_settlement_sum,
        // public ?object $applicable_term_payment_sum,
        // public ?object $term_fee_settlement_sum,
        // public ?object $receivable_dashboard_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // syste
        ];
    }
}
