<?php

namespace Modules\ExamManagement\Intents\SchedulingExamination\UpdateSchedulingExamination;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateSchedulingExaminationSystemDTO extends Data
{
    public function __construct(
        // system
        public int $updated_by,
        // public int $scheduling_examination_status_id,
        public int $scheduling_examination_status_type_id,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'updated_by' => [new Required, new IntegerType],
            // "scheduling_examination_status_id" =>  [new Required(), new IntegerType()],
            'scheduling_examination_status_type_id' => [new Required, new IntegerType],
        ];
    }
}
