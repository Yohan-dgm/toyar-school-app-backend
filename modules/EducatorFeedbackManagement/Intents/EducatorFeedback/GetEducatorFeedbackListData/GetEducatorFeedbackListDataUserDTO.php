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
        // Frontend parameter mapping
        public mixed $grade_filter = null,
        public mixed $evaluation_type_filter = null,
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

    public static function prepareForValidation(array $properties): array
    {
        // Map frontend parameters to backend parameters
        // Frontend sends: grade_filter
        // Backend uses: grade_level_id

        // Map grade_filter to grade_level_id if provided and not empty
        if (array_key_exists('grade_filter', $properties) && $properties['grade_filter'] !== '' && $properties['grade_filter'] !== null) {
            $properties['grade_level_id'] = (int) $properties['grade_filter'];
        }

        // Map evaluation_type_filter to evaluation_status (only if explicitly provided)
        // No default value - when null, backend will show ALL evaluation statuses
        if (array_key_exists('evaluation_type_filter', $properties) && $properties['evaluation_type_filter'] !== null && $properties['evaluation_type_filter'] !== '') {
            $properties['evaluation_status'] = (int) $properties['evaluation_type_filter'];
        }

        return $properties;
    }
}
