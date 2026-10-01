<?php

namespace Modules\AccountManagement\Intents\ExpenseCategory\GetExpenseCategoryListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetExpenseCategoryListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $expense_category_count,
        public ?object $expense_type_category_list_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
