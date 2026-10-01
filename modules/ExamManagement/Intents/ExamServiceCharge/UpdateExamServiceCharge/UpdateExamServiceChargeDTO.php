<?php

namespace Modules\ExamManagement\Intents\ExamServiceCharge\UpdateExamServiceCharge;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamServiceChargeDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public ?string $name,
        // system
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],

            // system
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
