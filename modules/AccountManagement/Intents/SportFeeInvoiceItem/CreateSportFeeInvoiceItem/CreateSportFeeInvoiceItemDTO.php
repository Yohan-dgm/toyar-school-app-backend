<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoiceItem\CreateSportFeeInvoiceItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSportFeeInvoiceItemDTO extends Data
{
    public function __construct(
        public int $sport_fee_invoice_id,
        public ?int $school_fee_id,
        // public ?int $sport_fee_item_id,
        public ?string $description,
        public ?float $unit_price,
        public ?float $qty,
        public ?float $item_total,

        // system
        public ?bool $is_sport_fee_invoice_item_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'sport_fee_invoice_id' => [new Required],

            // system
            'created_by' => [new Required],

        ];
    }
}
