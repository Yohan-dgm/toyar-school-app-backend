<?php

namespace Modules\AttendanceManagement\Intents\Stats\GetStudentAttendanceStats;

use Spatie\LaravelData\Data;

class GetStudentAttendanceStatsUserDTO extends Data
{
    public function __construct(
        public string $filter_type,      // 'month', 'year', 'term'
        public ?int $year = null,        // Required for 'month' and 'year' filters
        public ?int $month = null,       // Required for 'month' filter
        public ?int $term_id = null,     // Required for 'term' filter (1, 2, or 3)
    ) {}

    public static function rules(): array
    {
        return [
            'filter_type' => ['required', 'string', 'in:month,year,term'],
            'year' => ['nullable', 'integer', 'min:2020', 'max:2050'],
            'month' => ['nullable', 'integer', 'min:1', 'max:12'],
            'term_id' => ['nullable', 'integer', 'in:1,2,3'],
        ];
    }

    public static function messages(): array
    {
        return [
            'filter_type.required' => 'Filter type is required',
            'filter_type.in' => 'Filter type must be one of: month, year, term',
            'year.integer' => 'Year must be an integer',
            'year.min' => 'Year must be 2020 or later',
            'year.max' => 'Year must be 2050 or earlier',
            'month.integer' => 'Month must be an integer',
            'month.min' => 'Month must be between 1 and 12',
            'month.max' => 'Month must be between 1 and 12',
            'term_id.integer' => 'Term ID must be an integer',
            'term_id.in' => 'Term ID must be 1, 2, or 3',
        ];
    }
}
