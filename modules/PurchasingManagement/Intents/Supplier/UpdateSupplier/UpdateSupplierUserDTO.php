<?php

namespace Modules\PurchasingManagement\Intents\Supplier\UpdateSupplier;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSupplierUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $name,
        public string $supplier_type,
        public ?int $person_title_id,
        public string $phone,
        public ?string $email,
        public string $full_address,
        public int $country_id
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required],
            'supplier_type' => [new Required],
            'phone' => [new Required],
            'full_address' => [new Required],
            'country_id' => [new Required],
        ];
    }
}
