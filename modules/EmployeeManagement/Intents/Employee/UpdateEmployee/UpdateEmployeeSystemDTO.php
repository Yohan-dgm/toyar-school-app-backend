<?php

namespace Modules\EmployeeManagement\Intents\Employee\UpdateEmployee;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEmployeeSystemDTO extends Data
{
    public function __construct(
        // system
        public mixed $remaining_annual_leaves,
        public mixed $remaining_medical_leaves,
        public mixed $remaining_maternity_leaves,
        public string $full_name_with_title,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'remaining_annual_leaves' => [new Required, new Numeric],
            'remaining_medical_leaves' => [new Required, new Numeric],
            'remaining_maternity_leaves' => [new Required, new Numeric],
            'full_name_with_title' => [new Required, new StringType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
