<?php

namespace Modules\AdmissionManagement\Intents\Applicant\CreateApplicant;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateApplicantSystemDTO extends Data
{
    public function __construct(
        // system
        public int $created_by,
        public string $applicant_number,
        public int $applicant_number_digits,
        public string $applicant_number_prefix,
        public string $applicant_number_current_year,
        public string $full_name_with_title,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'created_by' => [new Required, new IntegerType],
            'applicant_number' => [new Required, new StringType, new Unique('applicant', 'applicant_number')],
            'applicant_number_digits' => [new Required, new IntegerType],
            'applicant_number_prefix' => [new Required, new StringType],
            'applicant_number_current_year' => [new Required, new StringType],
            'full_name_with_title' => [new Required, new StringType],
        ];
    }
}
