<?php

namespace Modules\AccountManagement\Intents\IncomeCategory\GetIncomeCategoryListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetIncomeCategoryListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $income_category_count,
        public ?object $income_type_category_list_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
