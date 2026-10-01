<?php

namespace Modules\ExamManagement\Intents\ExamPrivateCandidate\UpdateExamPrivateCandidate;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamPrivateCandidateDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $gender,
        public string $full_name,
        public ?string $phone,
        public ?string $email,
        public ?string $address,
        public int $student_admission_source_id,
        public ?string $student_admission_source_other,
        // system
        public string $full_name_with_title,
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
