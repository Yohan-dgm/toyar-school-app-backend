<?php

namespace Modules\ExamManagement\Intents\ExamServiceCharge\CreateExamServiceCharge;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamServiceChargeDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public float $exam_service_charge_amount,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType],

            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
