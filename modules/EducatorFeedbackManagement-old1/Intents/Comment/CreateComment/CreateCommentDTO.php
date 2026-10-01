<?php

namespace Modules\EducatorFeedbackManagement\Intents\Comment\CreateComment;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCommentDTO extends Data
{
    public function __construct(
        // user
        public int $edu_fb_id,
        public string $comment,
        // system
        public int $created_by,
        public ?int $updated_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'edu_fb_id' => [new Required, new IntegerType],
            'comment' => [new Required, new StringType],
            // system
            'created_by' => [new IntegerType],
            'updated_by' => ['nullable', new IntegerType],
        ];
    }
}
