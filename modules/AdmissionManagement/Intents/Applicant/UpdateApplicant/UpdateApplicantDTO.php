<?php

namespace Modules\AdmissionManagement\Intents\Applicant\UpdateApplicant;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateApplicantDTO extends Data
{
    public function __construct(
        // user
        public string $full_name,
        public string $gender,
        public Date $date_of_birth,
        public int $grade_level_id,
        public mixed $approved_admission_fee,
        public mixed $approved_refundable_deposit,
        public mixed $approved_term_payment,
        public int $start_term_id,

        // system
        public int $updated_by,
        public string $full_name_with_title,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'full_name' => [new Required, new StringType],
            'gender' => [new Required, new StringType],
            'date_of_birth' => [new Required, new Date],
            'grade_level_id' => [new Required, new IntegerType],

            // system
            'updated_by' => [new Required, new IntegerType],
            'full_name_with_title' => [new Required, new StringType],
        ];
    }
}
