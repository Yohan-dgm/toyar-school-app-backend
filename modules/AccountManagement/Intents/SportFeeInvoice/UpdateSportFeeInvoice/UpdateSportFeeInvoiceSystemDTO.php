<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoice\UpdateSportFeeInvoice;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSportFeeInvoiceSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
        public ?bool $is_sport_fee_invoice_complete,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
