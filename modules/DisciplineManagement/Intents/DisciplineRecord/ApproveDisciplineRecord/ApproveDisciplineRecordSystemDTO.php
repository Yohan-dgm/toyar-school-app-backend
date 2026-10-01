<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\ApproveDisciplineRecord;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ApproveDisciplineRecordSystemDTO extends Data
{
    public function __construct(
        public string $status,
        public int $reviewed_by,
        public string $reviewed_date,
        public int $updated_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'status' => [new Required, new StringType],
            'reviewed_by' => [new Required, new IntegerType],
            'reviewed_date' => [new Required],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
