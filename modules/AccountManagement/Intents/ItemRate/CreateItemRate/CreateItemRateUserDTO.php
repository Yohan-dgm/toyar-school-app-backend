<?php

namespace Modules\AccountManagement\Intents\ItemRate\CreateItemRate;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateItemRateUserDTO extends Data
{
    public function __construct(
        // user
        public string $item_type,
        public ?int $material_item_id,
        public ?int $service_item_id,
        public ?int $exam_service_charge_id,
        public float $rate,
        public ?string $notes,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'item_type' => [new Required, new StringType],
            'material_item_id' => [new IntegerType],
            'service_item_id' => [new IntegerType],
            'exam_service_charge_id' => [new IntegerType],
            'rate' => [new Required],
        ];
    }
}
