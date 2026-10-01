<?php

namespace Modules\AccountManagement\Intents\ReceivableAccount\GetReceivableAccountListData;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetReceivableAccountListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $receivable_account_count,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // syste
        ];
    }
}
