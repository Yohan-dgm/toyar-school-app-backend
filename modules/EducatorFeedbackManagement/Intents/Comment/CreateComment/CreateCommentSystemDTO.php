<?php

namespace Modules\EducatorFeedbackManagement\Intents\Comment\CreateComment;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateCommentSystemDTO extends Data
{
    public function __construct(
        // system
        public int $created_by,
        public ?int $updated_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // system
            'created_by' => [new IntegerType],
            'updated_by' => ['nullable', new IntegerType],
        ];
    }
}
