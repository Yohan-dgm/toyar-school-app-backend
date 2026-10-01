<?php

namespace Modules\AccountManagement\Intents\MaterialBillItem\CreateMaterialBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMaterialBillItemUserDTO extends Data
{
    public function __construct(
        // user
        public int $material_bill_id,
        public ?int $material_item_id,
        public ?float $item_quantity,
        public ?string $print_description,
        public ?float $print_quantity,
        public ?string $print_unit,
        public ?float $item_total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'material_bill_id' => [new Required],
        ];
    }
}
