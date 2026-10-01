<?php

namespace Modules\SportManagement\Intents\StudentSport\RemoveStudentFromSport;

use Spatie\LaravelData\Data;

class RemoveStudentFromSportUserDTO extends Data
{
    public function __construct(
        public int $student_id,
        public int $sport_id,
        public ?string $left_date = null,
        public ?string $reason = null,
        public ?string $notes = null,
    ) {}

    public static function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:student,id'],
            'sport_id' => ['required', 'integer', 'exists:sport,id'],
            'left_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'reason' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public static function messages(): array
    {
        return [
            'student_id.required' => 'Student ID is required',
            'student_id.exists' => 'Student not found',
            'sport_id.required' => 'Sport ID is required',
            'sport_id.exists' => 'Sport not found',
            'left_date.date_format' => 'Left date must be in Y-m-d format',
        ];
    }
}
