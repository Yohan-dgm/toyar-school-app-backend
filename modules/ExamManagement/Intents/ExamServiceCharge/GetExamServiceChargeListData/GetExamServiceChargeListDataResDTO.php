<?php

namespace Modules\ExamManagement\Intents\ExamServiceCharge\GetExamServiceChargeListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetExamServiceChargeListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $exam_service_charge_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // syste
        ];
    }
}
