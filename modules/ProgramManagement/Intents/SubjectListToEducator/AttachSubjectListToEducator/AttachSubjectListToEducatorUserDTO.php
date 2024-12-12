<?php

namespace Modules\ProgramManagement\Intents\SubjectListToEducator\AttachSubjectListToEducator;

use Spatie\LaravelData\Attributes\Validation\ArrayType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class AttachSubjectListToEducatorUserDTO extends Data
{
    public function __construct(
        // user
        public int $educator_id,
        public array $subject_list,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'educator_id' => [new Required(), new IntegerType()],
            'subject_list' => [new Required(), new ArrayType()],
            // system
        ];
    }
}
