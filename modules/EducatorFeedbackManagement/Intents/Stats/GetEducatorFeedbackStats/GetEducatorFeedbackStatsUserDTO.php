<?php

namespace Modules\EducatorFeedbackManagement\Intents\Stats\GetEducatorFeedbackStats;

use Spatie\LaravelData\Data;

class GetEducatorFeedbackStatsUserDTO extends Data
{
    public function __construct(
        public ?string $period = null,
    ) {}

    public static function rules(): array
    {
        return [
            'period' => ['nullable', 'string', 'in:this_week,this_month,this_year'],
        ];
    }

    public static function messages(): array
    {
        return [
            'period.string' => 'Period must be a string',
            'period.in' => 'Period must be one of: this_week, this_month, this_year',
        ];
    }
}
