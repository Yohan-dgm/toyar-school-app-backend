<?php

namespace Modules\ExamManagement\Intents\ExamServiceCharge\CreateExamServiceCharge;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamServiceChargeUserDTO extends Data
{
    public function __construct(
        // user
        public string $name,
        public float $exam_service_charge_amount,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType],
        ];
    }
}
