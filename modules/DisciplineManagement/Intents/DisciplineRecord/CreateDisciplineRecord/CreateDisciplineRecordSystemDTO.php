<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\CreateDisciplineRecord;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateDisciplineRecordSystemDTO extends Data
{
    public function __construct(
        public string $academic_year,
        public ?string $grade_class_at_time,
        public string $status,
        public int $reported_by,
        public ?int $reviewed_by,
        public ?string $reviewed_date,
        public int $created_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'academic_year' => [new Required, new StringType],
            'grade_class_at_time' => [],
            'status' => [new Required, new StringType],
            'reported_by' => [new Required, new IntegerType],
            'reviewed_by' => [],
            'reviewed_date' => [],
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
