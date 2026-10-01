<?php

namespace Modules\AccountManagement\Intents\RefundableDepositItem\CreateRefundableDepositItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateRefundableDepositItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $refundable_deposit_id,
        public ?float $school_fee_id,
        public ?string $description,
        public ?float $item_total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'refundable_deposit_id' => [new Required],
        ];
    }
}
