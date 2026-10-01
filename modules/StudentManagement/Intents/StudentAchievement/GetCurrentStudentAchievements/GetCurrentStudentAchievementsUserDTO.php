<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\GetCurrentStudentAchievements;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCurrentStudentAchievementsUserDTO extends Data
{
    public function __construct(
        public int $student_id,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'student_id' => [new Required, new IntegerType, 'exists:student,id'],
        ];
    }
}
