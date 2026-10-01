<?php

namespace Modules\ExamManagement\Intents\ExamPrivateCandidate\CreateExamPrivateCandidate;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamPrivateCandidateDTO extends Data
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

        // system
        public string $full_name_with_title,
        public string $exam_private_candidate_number,
        public int $exam_private_candidate_number_digits,
        public string $exam_private_candidate_number_prefix,
        public string $exam_private_candidate_number_current_year,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
