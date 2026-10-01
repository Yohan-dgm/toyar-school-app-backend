<?php

namespace Modules\StudentManagement\Intents\StudentSport\GetStudentSportListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentSportListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $student_sport_count,
        public ?object $student_sport_status_type_count,
        public ?object $student_sport_type_count,
        public ?object $student_sport_type_count_2,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
