<?php

namespace Modules\AccountManagement\Intents\TermFeeInvoice\UpdateTermFeeInvoice;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateTermFeeInvoiceSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
        public ?bool $is_term_fee_invoice_complete,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
