<?php

namespace Modules\EmployeeManagement\Intents\Employee\CreateEmployee;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateEmployeeDTO extends Data
{
    public function __construct(
        // user
        public mixed $full_name,
        public mixed $person_title_id,
        public mixed $calling_name,
        public mixed $gender,
        public mixed $date_of_birth,
        public ?string $marital_status,
        public mixed $phone,
        public mixed $email,
        public mixed $address,
        public mixed $employee_id_type,
        public mixed $nic_number,
        public mixed $passport_number,
        public mixed $epf_number,
        public mixed $designation_id,
        public mixed $blood_group,
        public mixed $special_health_conditions,
        public ?Date $joined_date,
        public Date $employee_type_id,
        // system
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
        return [
            // user
            'full_name' => [new Required, new StringType],
            'person_title_id' => [new Required, new IntegerType],
            'gender' => [new Required, new StringType],
            'joined_date' => [new Required, new Date],

            // system
            'created_by' => [new Required, new IntegerType],
            'employee_number' => [new Required, new StringType, new Unique('employee', 'employee_number')],
            'employee_number_digits' => [new Required, new IntegerType],
            'employee_number_prefix' => [new Required, new StringType],
            'employee_number_current_year' => [new Required, new StringType],
            'full_name_with_title' => [new Required, new StringType],

        ];
    }
}
