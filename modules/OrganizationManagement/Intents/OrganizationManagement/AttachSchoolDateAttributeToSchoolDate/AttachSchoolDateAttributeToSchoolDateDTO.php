<?php

namespace Modules\OrganizationManagement\Intents\OrganizationManagement\AttachSchoolDateAttributeToSchoolDate;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class AttachSchoolDateAttributeToSchoolDateDTO extends Data
{
    public function __construct(
        // user
        public string $date_selection_type,
        public string $period_start_date,
        public string $period_end_date,
        public string $date,
        public int $school_date_attribute_id,

        // system
        public int $created_by
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'date_selection_type' => [new Required],
            'date' => [new RequiredIf('date_selection_type', '=', '1 Day')],
            'period_start_date' => [new RequiredIf('date_selection_type', '=', 'Period')],
            'period_end_date' => [new RequiredIf('date_selection_type', '=', 'Period')],
            'school_date_attribute_id' => [new Required, new IntegerType],
            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
