<?php

namespace Modules\StudentManagement\Intents\StudentSport\UpdateStudentSport;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateStudentSportUserDTO extends Data
{
    public function __construct(
        // user
        public ?int $student_id,
        public ?array $student_sport_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required],
        ];
    }
}
