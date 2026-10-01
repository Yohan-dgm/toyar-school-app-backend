<?php

namespace Modules\ExamManagement\Intents\ExamPrivateCandidate\CreateExamPrivateCandidate;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamPrivateCandidateSystemDTO extends Data
{
    public function __construct(
        public string $full_name_with_title,
        public string $exam_private_candidate_number,
        public int $exam_private_candidate_number_digits,
        public string $exam_private_candidate_number_prefix,
        public string $exam_private_candidate_number_current_year,
        public int $created_by
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
