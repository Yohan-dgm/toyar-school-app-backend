<?php

namespace Modules\ExamManagement\Intents\ExamQuiz\CreateExamQuiz;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\RequiredIf;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateExamQuizDTO extends Data
{
    public function __construct(
        // user
        public string $exam_type, //Quizzes, Term Exams, Cambridge Exam
        public int $program_id,
        public ?int $subject_id,
        public Date $exam_start_date,
        public Date $exam_end_date,
        public string $exam_start_time,
        public string $exam_end_time,
        public string $exam_title,
        public ?string $description,

        // system
        public int $created_by,
        public bool $is_active,

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'exam_type' => [new Required, new StringType],
            'program_id' => [new IntegerType, new Required],
            'subject_id' => [new RequiredIf('type', 'Term Exams')],
            'exam_start_date' => [new Date, new Required],
            'exam_end_date' => [new Date, new Required],
            'exam_start_time' => [new Required],
            'exam_end_time' => [new Required],
            'exam_title' => [new StringType, new Required],
            'description' => [new StringType],

            // system
            'created_by' => [new Required, new IntegerType],
            'is_active' => [new Required, new BooleanType],
        ];
    }
}
