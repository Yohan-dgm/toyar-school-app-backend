<?php

namespace Modules\DisciplineManagement\Intents\MisconductLevel\CreateMisconductLevel;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateMisconductLevelDTO extends Data
{
    public function __construct(
        // user
        public int $level_number,
        public string $level_name,
        public string $nature_of_offence,
        public int $indicative_deduction_min,
        public int $indicative_deduction_max,
        public ?string $examples,
        public int $approval_tier,
        public ?bool $is_active,
        // system
        public int $created_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'level_number' => [new Required, new IntegerType],
            'level_name' => [new Required, new StringType],
            'nature_of_offence' => [new Required, new StringType],
            'indicative_deduction_min' => [new Required, new IntegerType],
            'indicative_deduction_max' => [new Required, new IntegerType],
            'examples' => [],
            'approval_tier' => [new Required, new IntegerType],
            'is_active' => [],
            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
