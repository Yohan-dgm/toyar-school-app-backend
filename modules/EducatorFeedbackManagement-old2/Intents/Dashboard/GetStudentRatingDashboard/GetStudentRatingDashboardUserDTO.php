<?php

namespace Modules\EducatorFeedbackManagement\Intents\Dashboard\GetStudentRatingDashboard;

use Spatie\LaravelData\Data;

class GetStudentRatingDashboardUserDTO extends Data
{
    public function __construct(
        public int $student_id,
        public ?int $year = null,
        public ?int $month = null,
        public ?int $status = 2,
    ) {}

    public static function rules(): array
    {
        return [
            'student_id' => ['required', 'integer', 'min:1'],
            'year' => ['nullable', 'integer', 'min:2020', 'max:2050'],
            'month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'status' => ['nullable', 'integer'],
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
            'month.integer' => 'Month must be an integer',
            'month.min' => 'Month must be between 1 and 12',
            'month.max' => 'Month must be between 1 and 12',
            'status.integer' => 'Status must be an integer',
        ];
    }
}
