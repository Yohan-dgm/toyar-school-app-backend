<?php

namespace Modules\ExamManagement\Intents\ExamPrivateCandidate\UpdateExamPrivateCandidate;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateExamPrivateCandidateUserDTO extends Data
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
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
        ];
    }
}
