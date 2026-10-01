<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\GetCurrentStudentAchievements;

use Spatie\LaravelData\Data;

class GetCurrentStudentAchievementsResDTO extends Data
{
    public function __construct(
        public int $student_id,
        public array $student_info,
        public array $current_achievements,
        public int $total_achievements,
        public string $current_date,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            student_id: $data['student_id'],
            student_info: $data['student_info'] ?? [],
            current_achievements: $data['current_achievements'] ?? [],
            total_achievements: $data['total_achievements'] ?? 0,
            current_date: $data['current_date'] ?? date('Y-m-d'),
        );
    }
}
