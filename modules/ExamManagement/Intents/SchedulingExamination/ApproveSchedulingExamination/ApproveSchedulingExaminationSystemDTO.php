<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\ApproveSchedulingExamination;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ApproveSchedulingExaminationSystemDTO extends Data
{
    public function __construct(
        public int $updated_by,
        public int $scheduling_examination_status_type_id,
        public int $approved_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'updated_by' => [new Required, new IntegerType],
            'scheduling_examination_status_type_id' => [new Required, new IntegerType],
            'approved_by' => [new Required, new IntegerType],
        ];
    }
}
