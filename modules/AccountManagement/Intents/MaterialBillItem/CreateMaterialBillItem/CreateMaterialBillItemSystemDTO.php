<?php

namespace Modules\AccountManagement\Intents\MaterialBillItem\CreateMaterialBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMaterialBillItemSystemDTO extends Data
{
    public function __construct(
        public ?float $ordered_quantity,
        public ?float $billed_quantity,
        public ?float $issued_quantity,
        public ?bool $is_material_bill_item_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
        ];
    }
}
