<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoiceItem\CreateSportFeeInvoiceItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSportFeeInvoiceItemSystemDTO extends Data
{
    public function __construct(
        public ?bool $is_sport_fee_invoice_item_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
