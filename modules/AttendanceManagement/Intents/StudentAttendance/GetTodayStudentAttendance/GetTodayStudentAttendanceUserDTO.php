<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetTodayStudentAttendance;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetTodayStudentAttendanceUserDTO extends Data
{
    public function __construct(
        public ?int $grade_level_class_id,
        public int $page,
        public int $page_size,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'grade_level_class_id' => ['nullable', new IntegerType],
            'page' => ['nullable', new IntegerType, 'min:1'],
            'page_size' => ['nullable', new IntegerType, 'min:1', 'max:100'],
        ];
    }

    public static function prepareForValidation(array $data): array
    {
        $data['page'] = $data['page'] ?? 1;
        $data['page_size'] = $data['page_size'] ?? 50;

        return $data;
    }
}
