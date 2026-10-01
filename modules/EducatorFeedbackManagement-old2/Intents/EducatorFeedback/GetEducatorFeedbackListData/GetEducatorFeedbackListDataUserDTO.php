<?php

namespace Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\GetEducatorFeedbackListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetEducatorFeedbackListDataUserDTO extends Data
{
    public function __construct(
        // user
        public ?int $student_id,
        public ?int $grade_level_id,
        public ?int $edu_fb_category_id,
        public ?int $evaluation_status,
        public ?string $date_from,
        public ?string $date_to,
        public ?string $search_phrase,
        public ?array $search_filter_list,
        public int $page_size,
        public int $page,
        // system

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'page_size' => [new Required, new IntegerType],
            'page' => [new Required, new IntegerType],
            // system
        ];
    }
}
