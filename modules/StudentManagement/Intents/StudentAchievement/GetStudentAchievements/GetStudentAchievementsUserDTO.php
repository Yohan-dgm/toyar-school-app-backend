<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\GetStudentAchievements;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentAchievementsUserDTO extends Data
{
    public function __construct(
        public int $page,
        public int $page_size,
        public ?string $group_filter,
        public ?array $search_filter_list,
        public ?string $search_phrase,
        public ?int $student_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'page' => [new Required, new IntegerType],
            'page_size' => [new Required, new IntegerType],
            'group_filter' => [new StringType],
            'search_phrase' => [new StringType],
            'student_id' => [new IntegerType],
        ];
    }
}
