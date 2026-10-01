<?php

namespace Modules\EducatorFeedbackManagement\Intents\Dashboard\GetStudentRatingByTerm;

use Spatie\LaravelData\Data;

class GetStudentRatingByTermUserDTO extends Data
{
    public function __construct(
        public int $student_id,
        public ?int $year = null,
    ) {}

    public static function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'min:1'],
            'year' => ['nullable', 'integer', 'min:2020', 'max:2050'],
        ];
    }

    public static function messages(): array
    {
        return [
            'student_id.required' => 'Student ID is required',
            'student_id.integer' => 'Student ID must be an integer',
            'student_id.min' => 'Student ID must be greater than 0',
            'year.integer' => 'Year must be an integer',
            'year.min' => 'Year must be 2020 or later',
            'year.max' => 'Year must be 2050 or earlier',
        ];
    }
}
