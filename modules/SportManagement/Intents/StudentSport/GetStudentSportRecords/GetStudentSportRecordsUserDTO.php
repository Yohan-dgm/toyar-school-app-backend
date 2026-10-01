<?php

namespace Modules\SportManagement\Intents\StudentSport\GetStudentSportRecords;

use Spatie\LaravelData\Data;

class GetStudentSportRecordsUserDTO extends Data
{
    public function __construct(
        public int $student_id,
        public ?int $sport_id = null,
        public ?string $action_type = null,
        public ?string $from_date = null,
        public ?string $to_date = null,
        public ?bool $include_active_only = null,
    ) {}

    public static function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:student,id'],
            'sport_id' => ['nullable', 'integer', 'exists:sport,id'],
            'action_type' => ['nullable', 'string', 'in:enrolled,left,coach_changed,reactivated'],
            'from_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'to_date' => ['nullable', 'date', 'date_format:Y-m-d', 'after_or_equal:from_date'],
            'include_active_only' => ['nullable', 'boolean'],
        ];
    }

    public static function messages(): array
    {
        return [
            'student_id.required' => 'Student ID is required',
            'student_id.exists' => 'Student not found',
            'sport_id.exists' => 'Sport not found',
            'action_type.in' => 'Action type must be one of: enrolled, left, coach_changed, reactivated',
            'from_date.date_format' => 'From date must be in Y-m-d format',
            'to_date.date_format' => 'To date must be in Y-m-d format',
            'to_date.after_or_equal' => 'To date must be after or equal to from date',
        ];
    }
}
