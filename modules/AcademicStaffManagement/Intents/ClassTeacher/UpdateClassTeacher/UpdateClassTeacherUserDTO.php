<?php

namespace Modules\AcademicStaffManagement\Intents\ClassTeacher\UpdateClassTeacher;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateClassTeacherUserDTO extends Data
{
    public function __construct(
        public mixed $id,
        public mixed $user_id,
        public mixed $grade_level_class_id,
        public mixed $academic_year,
        public mixed $start_date,
        public mixed $end_date,
        public mixed $is_active,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'id' => [new Required, new IntegerType, 'exists:class_teacher,id'],
            'user_id' => [new IntegerType, 'exists:user,id'],
            'grade_level_class_id' => [new IntegerType, 'exists:grade_level_class,id'],
            'academic_year' => [new StringType],
            'start_date' => [new Date],
            'end_date' => [new Date, 'nullable', 'after_or_equal:start_date'],
            'is_active' => ['boolean'],
        ];
    }

    public static function messages(): array
    {
        return [
            'id.required' => 'Class teacher ID is required',
            'id.integer' => 'Class teacher ID must be an integer',
            'id.exists' => 'Class teacher assignment does not exist',
            'user_id.integer' => 'User ID must be an integer',
            'user_id.exists' => 'User does not exist',
            'grade_level_class_id.integer' => 'Grade level class ID must be an integer',
            'grade_level_class_id.exists' => 'Grade level class does not exist',
            'academic_year.string' => 'Academic year must be a string',
            'start_date.date' => 'Start date must be a valid date',
            'end_date.date' => 'End date must be a valid date',
            'end_date.after_or_equal' => 'End date must be after or equal to start date',
            'is_active.boolean' => 'Is active must be a boolean',
        ];
    }
}
