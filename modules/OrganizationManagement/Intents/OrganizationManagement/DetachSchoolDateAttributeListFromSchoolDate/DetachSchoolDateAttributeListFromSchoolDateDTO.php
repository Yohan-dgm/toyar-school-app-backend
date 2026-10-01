<?php

namespace Modules\OrganizationManagement\Intents\OrganizationManagement\DetachSchoolDateAttributeListFromSchoolDate;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class DetachSchoolDateAttributeListFromSchoolDateDTO extends Data
{
    public function __construct(
        // user
        public string $date,
        public array $school_date_attribute_list,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required],
            'school_date_attribute_list' => [new Required, new ArrayType],
            // system
        ];
    }
}
