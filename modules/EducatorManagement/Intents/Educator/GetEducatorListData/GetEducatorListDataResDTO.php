<?php

namespace Modules\EducatorManagement\Intents\Educator\GetEducatorListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetEducatorListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $educator_count,

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
