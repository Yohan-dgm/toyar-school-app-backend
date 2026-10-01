<?php

namespace Modules\AccountManagement\Intents\MaterialBill\UpdateMaterialBill;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateMaterialBillSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
        public ?bool $is_material_bill_complete,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required],
        ];
    }
}
