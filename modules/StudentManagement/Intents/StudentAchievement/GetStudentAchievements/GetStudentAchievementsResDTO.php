<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\GetStudentAchievements;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class GetStudentAchievementsResDTO extends Data
{
    public function __construct(
        public array $data,
        public int $current_page,
        public int $last_page,
        public int $per_page,
        public int $total,
        public int $student_achievement_count,
    ) {}

    public static function rules(): array
    {
        return [
            'current_page' => [new Required, new IntegerType],
            'last_page' => [new Required, new IntegerType],
            'per_page' => [new Required, new IntegerType],
            'total' => [new Required, new IntegerType],
            'student_achievement_count' => [new Required, new IntegerType],
        ];
    }
}
