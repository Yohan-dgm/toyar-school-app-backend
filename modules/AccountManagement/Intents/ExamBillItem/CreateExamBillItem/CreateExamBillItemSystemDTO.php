<?php

namespace Modules\AccountManagement\Intents\ExamBillItem\CreateExamBillItem;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamBillItemSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public string $rate_id_list,
        public string $rate_list,
        public float $subtotal,
        public float $total,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required],
            'rate_id_list' => [new Required],
            'rate_list' => [new Required],
            'subtotal' => [new Required],
            'total' => [new Required],
        ];
    }
}
