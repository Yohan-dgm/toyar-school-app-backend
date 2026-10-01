<?php

namespace Modules\EmployeeManagement\Intents\Employee\UpdateEmployee;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEmployeeDTO extends Data
{
    public function __construct(
        // user
        public int $employee_id,
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
        public int $updated_by,
        public mixed $remaining_annual_leaves,
        public mixed $remaining_medical_leaves,
        public mixed $remaining_maternity_leaves,
        public string $full_name_with_title,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'employee_id' => [new Required, new IntegerType],
            'full_name' => [new Required, new StringType],
            'person_title_id' => [new Required, new IntegerType],
            'gender' => [new Required, new StringType],
            'joined_date' => [new Required, new Date],

            // system
            'updated_by' => [new Required, new IntegerType],
            'full_name_with_title' => [new Required, new StringType],
        ];
    }
}
