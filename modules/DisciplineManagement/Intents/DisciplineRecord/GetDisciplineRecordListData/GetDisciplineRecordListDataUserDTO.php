<?php

namespace Modules\DisciplineManagement\Intents\DisciplineRecord\GetDisciplineRecordListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetDisciplineRecordListDataUserDTO extends Data
{
    public function __construct(
        // user
        public ?string $grade_class_at_time,
        public ?string $academic_year,
        public ?string $status,
        public ?string $search_phrase,
        public int $page_size,
        public int $page,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'grade_class_at_time' => [],
            'academic_year' => [],
            'status' => [],
            'search_phrase' => [],
            'page_size' => [new Required, new IntegerType],
            'page' => [new Required, new IntegerType],
            // system
        ];
    }
}
