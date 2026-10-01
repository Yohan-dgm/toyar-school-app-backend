<?php

namespace Modules\EmployeeManagement\Intents\Employee\CreateEmployee;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Numeric;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateEmployeeSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public mixed $remaining_annual_leaves,
        public mixed $remaining_medical_leaves,
        public mixed $remaining_maternity_leaves,
        public string $employee_number,
        public int $employee_number_digits,
        public string $employee_number_prefix,
        public string $employee_number_current_year,
        public string $full_name_with_title,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            'created_by' => [new Required, new IntegerType],
            'remaining_annual_leaves' => [new Required, new Numeric],
            'remaining_medical_leaves' => [new Required, new Numeric],
            'remaining_maternity_leaves' => [new Required, new Numeric],
            'employee_number' => [new Required, new StringType, new Unique('employee', 'employee_number')],
            'employee_number_digits' => [new Required, new IntegerType],
            'employee_number_prefix' => [new Required, new StringType],
            'employee_number_current_year' => [new Required, new StringType],
            'full_name_with_title' => [new Required, new StringType],
        ];
    }
}
