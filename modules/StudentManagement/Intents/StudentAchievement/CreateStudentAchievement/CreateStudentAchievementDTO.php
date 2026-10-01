<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\CreateStudentAchievement;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateStudentAchievementDTO extends Data
{
    public function __construct(
        public int $student_id,
        public string $achievement_type,
        public string $title,
        public ?string $description,
        public ?bool $is_active,
        public ?string $start_date,
        public ?string $end_date,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'student_id' => [new Required, new IntegerType],
            'achievement_type' => [new Required, new StringType],
            'title' => [new Required, new StringType],
            'description' => [new StringType],
            'is_active' => [new BooleanType],
            'start_date' => [new Date],
            'end_date' => [new Date],
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
