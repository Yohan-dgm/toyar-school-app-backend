<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\UpdateDisciplineRecord;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateDisciplineRecordSystemDTO extends Data
{
    public function __construct(
        public string $academic_year,
        public int $updated_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'academic_year' => [new Required, new StringType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
