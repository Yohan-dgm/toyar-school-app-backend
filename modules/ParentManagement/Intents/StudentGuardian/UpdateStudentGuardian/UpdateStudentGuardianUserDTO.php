<?php

namespace Modules\ParentManagement\Intents\StudentGuardian\UpdateStudentGuardian;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateStudentGuardianUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public mixed $full_name,
        public mixed $id_type,
        public mixed $nic_number,
        public mixed $passport_number,
        public mixed $phone,
        public mixed $whatsapp,
        public mixed $email,
        public mixed $occupation,
        public mixed $place_of_work,
        public mixed $monthly_income,
        public mixed $guardian_type, // 1=father, 2=mother, 3=guardian
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required],
            'full_name' => [new Required, new StringType],
            // system
        ];
    }
}
