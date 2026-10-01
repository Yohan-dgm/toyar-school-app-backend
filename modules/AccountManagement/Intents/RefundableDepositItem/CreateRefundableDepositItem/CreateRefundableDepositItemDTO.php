<?php

namespace Modules\AccountManagement\Intents\RefundableDepositItem\CreateRefundableDepositItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateRefundableDepositItemDTO extends Data
{
    public function __construct(
        public int $refundable_deposit_id,
        public ?float $school_fee_id,
        public ?string $description,
        public ?float $item_total,

        // system
        public ?string $serial_number_prefix,
        public ?int $serial_number_digits,
        public ?string $serial_number_current_year,
        public ?string $serial_number_financial_year,
        public ?string $serial_number_suffix,
        public ?string $serial_number,
        public ?bool $is_refundable_deposit_item_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'refundable_deposit_id' => [new Required],

            // system
            'created_by' => [new Required],

        ];
    }
}
