<?php

namespace Modules\EducatorFeedbackManagement\Intents\Comment\CreateComment;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCommentUserDTO extends Data
{
    public function __construct(
        // user
        public int $edu_fb_id,
        public string $comment,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'edu_fb_id' => [new Required, new IntegerType],
            'comment' => [new Required, new StringType],
        ];
    }
}
