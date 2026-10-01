<?php

namespace Modules\AcademicStaffManagement\Intents\SectionalHead\CreateSectionalHead;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateSectionalHeadUserDTO extends Data
{
    public function __construct(
        public mixed $user_id,
        public mixed $grade_level_id,
        public mixed $academic_year,
        public mixed $start_date,
        public mixed $end_date,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'user_id' => [new Required, new IntegerType, 'exists:user,id'],
            'grade_level_id' => [new Required, new IntegerType, 'exists:grade_level,id'],
            'academic_year' => [new Required, new StringType],
            'start_date' => [new Required, new Date],
            'end_date' => [new Date, 'nullable', 'after_or_equal:start_date'],
        ];
    }

    public static function messages(): array
    {
        return [
            'user_id.required' => 'User ID is required',
            'user_id.integer' => 'User ID must be an integer',
            'user_id.exists' => 'User does not exist',
            'grade_level_id.required' => 'Grade level ID is required',
            'grade_level_id.integer' => 'Grade level ID must be an integer',
            'grade_level_id.exists' => 'Grade level does not exist',
            'academic_year.required' => 'Academic year is required',
            'academic_year.string' => 'Academic year must be a string',
            'start_date.required' => 'Start date is required',
            'start_date.date' => 'Start date must be a valid date',
            'end_date.date' => 'End date must be a valid date',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
        ];
    }
}
