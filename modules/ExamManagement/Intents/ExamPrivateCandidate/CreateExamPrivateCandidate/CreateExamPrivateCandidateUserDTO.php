<?php

namespace Modules\ExamManagement\Intents\ExamPrivateCandidate\CreateExamPrivateCandidate;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamPrivateCandidateUserDTO extends Data
{
    public function __construct(
        // user
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
        ];
    }
}
