<?php

namespace Modules\SportManagement\Intents\StudentSport\UpdateStudentSport;

use Spatie\LaravelData\Data;

class UpdateStudentSportUserDTO extends Data
{
    public function __construct(
        public int $student_id,
        public int $sport_id,
        public ?int $coach_id = null,
        public ?string $enrolled_date = null,
        public ?bool $is_active = null,
        public ?string $notes = null,
    ) {}

    public static function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'exists:student,id'],
            'sport_id' => ['required', 'integer', 'exists:sport,id'],
            'coach_id' => ['nullable', 'integer', 'exists:educator,id'],
            'enrolled_date' => ['nullable', 'date', 'date_format:Y-m-d'],
            'is_active' => ['nullable', 'boolean'],
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
            'coach_id.exists' => 'Coach not found',
            'enrolled_date.date_format' => 'Enrolled date must be in Y-m-d format',
        ];
    }
}
