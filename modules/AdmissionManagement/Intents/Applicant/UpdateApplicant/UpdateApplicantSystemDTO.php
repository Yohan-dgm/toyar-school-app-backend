<?php

namespace Modules\AdmissionManagement\Intents\Applicant\UpdateApplicant;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateApplicantSystemDTO extends Data
{
    public function __construct(
        // system
        public int $updated_by,
        public string $full_name_with_title,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'updated_by' => [new Required, new IntegerType],
            'full_name_with_title' => [new Required, new StringType],
        ];
    }
}
