<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\GetDisciplineGradeDashboard;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetDisciplineGradeDashboardUserDTO extends Data
{
    public function __construct(
        // user
        public array $grade_level_class_ids,
        public ?string $academic_year,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'grade_level_class_ids' => [new Required],
            'academic_year' => [],
            // system
        ];
    }
}
