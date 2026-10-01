<?php

namespace Modules\AcademicStaffManagement\Intents\SectionalHead\UpdateSectionalHead;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSectionalHeadUserDTO extends Data
{
    public function __construct(
        public mixed $id,
        public mixed $user_id,
        public mixed $grade_level_id,
        public mixed $academic_year,
        public mixed $start_date,
        public mixed $end_date,
        public mixed $is_active,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'id' => [new Required, new IntegerType, 'exists:sectional_head,id'],
            'user_id' => [new IntegerType, 'exists:user,id'],
            'grade_level_id' => [new IntegerType, 'exists:grade_level,id'],
            'academic_year' => [new StringType],
            'start_date' => [new Date],
            'end_date' => [new Date, 'nullable', 'after_or_equal:start_date'],
            'is_active' => ['boolean'],
        ];
    }

    public static function messages(): array
    {
        return [
            'id.required' => 'Sectional head ID is required',
            'id.integer' => 'Sectional head ID must be an integer',
            'id.exists' => 'Sectional head assignment does not exist',
            'user_id.integer' => 'User ID must be an integer',
            'user_id.exists' => 'User does not exist',
            'grade_level_id.integer' => 'Grade level ID must be an integer',
            'grade_level_id.exists' => 'Grade level does not exist',
            'academic_year.string' => 'Academic year must be a string',
            'start_date.date' => 'Start date must be a valid date',
            'end_date.date' => 'End date must be a valid date',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
            'is_active.boolean' => 'Is active must be a boolean',
        ];
    }
}
