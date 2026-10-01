<?php

namespace Modules\StudentManagement\Intents\StudentInsights\GetStudentInsightsListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetStudentInsightsListDataUserDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        // system

    ) {
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'student_id' => [new Required(), new IntegerType()],
            // system
        ];
    }
}
