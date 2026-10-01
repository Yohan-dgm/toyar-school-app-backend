<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceById;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentAttendanceByIdUserDTO extends Data
{
    public function __construct(
        // Required fields
        public int $student_id,

        // Optional pagination
        public int $page = 1,
        public int $page_size = 10,

        // Optional filters
        public ?string $date_from = null,
        public ?string $date_to = null,
        public ?int $attendance_type_id = null,
        public ?string $search_phrase = null,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // Required fields
            'student_id' => [new Required, new IntegerType],

            // Optional pagination
            'page' => [new IntegerType],
            'page_size' => [new IntegerType],

            // Optional filters
            'date_from' => ['nullable', 'date'],
            'date_to' => ['nullable', 'date'],
            'attendance_type_id' => ['nullable', new IntegerType],
            'search_phrase' => ['nullable', 'string'],
        ];
    }

    public static function messages(): array
    {
        return [
            'student_id.required' => 'Student ID is required',
            'student_id.integer' => 'Student ID must be an integer',
            'page.integer' => 'Page must be an integer',
            'page_size.integer' => 'Page size must be an integer',
            'date_from.date' => 'Date from must be a valid date',
            'date_to.date' => 'Date to must be a valid date',
            'attendance_type_id.integer' => 'Attendance type ID must be an integer',
            'search_phrase.string' => 'Search phrase must be a string',
        ];
    }
}
