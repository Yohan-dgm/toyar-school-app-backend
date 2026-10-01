<?php

namespace Modules\StudentManagement\Intents\StudentSport\CreateStudentSport;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateStudentSportDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public ?array $student_sport_list,

        // system
        public int $created_by,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required, new IntegerType],

            // system
            // "created_by" =>  [new Required()],

        ];
    }
}
