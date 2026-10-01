<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\ApproveSchedulingExamination;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ApproveSchedulingExaminationUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
        ];
    }
}
