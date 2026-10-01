<?php

namespace Modules\AttendanceManagement\Intents\StudentAttendance\GetStudentAttendanceByDateAndClass;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentAttendanceByDateAndClassUserDTO extends Data
{
    public function __construct(
        // user
        public string $date,
        public int $grade_level_class_id,
        public int $page,
        public int $page_size,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'date' => [new Required, 'date_format:Y-m-d'],
            'grade_level_class_id' => [new Required, new IntegerType],
            'page' => ['nullable', new IntegerType, 'min:1'],
            'page_size' => ['nullable', new IntegerType, 'min:1', 'max:100'],
            // system
        ];
    }

    /**
     * Set default values for optional parameters
     */
    public static function prepareForValidation(array $data): array
    {
        $data['page'] = $data['page'] ?? 1;
        $data['page_size'] = $data['page_size'] ?? 50;

        return $data;
    }
}
