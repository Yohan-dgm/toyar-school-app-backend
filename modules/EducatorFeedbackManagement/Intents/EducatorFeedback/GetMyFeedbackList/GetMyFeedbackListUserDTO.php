<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\GetMyFeedbackList;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetMyFeedbackListUserDTO extends Data
{
    public function __construct(
        public ?int $grade_level_id,
        public ?int $page,
        public ?int $page_size,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'grade_level_id' => [new Nullable, new IntegerType],
            'page' => [new Nullable, new IntegerType, new Min(1)],
            'page_size' => [new Nullable, new IntegerType, new Min(1), new Max(100)],
        ];
    }
}
