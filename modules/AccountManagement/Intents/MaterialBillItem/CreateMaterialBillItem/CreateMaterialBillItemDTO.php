<?php

namespace Modules\AccountManagement\Intents\MaterialBillItem\CreateMaterialBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMaterialBillItemDTO extends Data
{
    public function __construct(
        public int $material_bill_id,
        public ?int $material_item_id,
        public ?float $item_quantity,
        public ?string $print_description,
        public ?float $print_quantity,
        public ?string $print_unit,
        public ?float $item_total,

        // system
        public ?float $ordered_quantity,
        public ?float $billed_quantity,
        public ?float $issued_quantity,
        public ?bool $is_material_bill_item_complete,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'material_bill_id' => [new Required],

            // system
            'created_by' => [new Required],

        ];
    }
}
