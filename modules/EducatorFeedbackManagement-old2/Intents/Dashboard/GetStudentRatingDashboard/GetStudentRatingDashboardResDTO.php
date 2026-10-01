<?php

namespace Modules\EducatorFeedbackManagement\Intents\Dashboard\GetStudentRatingDashboard;

use Spatie\LaravelData\Data;

class GetStudentRatingDashboardResDTO extends Data
{
    public function __construct(
        public array $student_info,
        public array $summary,
        public array $categories,
    ) {}

    public static function from(mixed ...$payloads): static
    {
        $data = $payloads[0];

        return new static(
            student_info: $data['student_info'] ?? [],
            summary: $data['summary'] ?? [],
            categories: $data['categories'] ?? [],
        );
    }
}
