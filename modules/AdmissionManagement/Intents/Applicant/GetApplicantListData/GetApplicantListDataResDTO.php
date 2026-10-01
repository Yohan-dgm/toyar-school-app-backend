<?php

namespace Modules\AdmissionManagement\Intents\Applicant\GetApplicantListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetApplicantListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $applicant_count,
        public ?object $waiting_list_applicant_count,
        public ?object $converted_applicant_count,
        public ?object $grade_level_applicant_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
