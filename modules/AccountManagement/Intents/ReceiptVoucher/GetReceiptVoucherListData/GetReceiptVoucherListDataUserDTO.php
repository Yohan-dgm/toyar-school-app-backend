<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\GetReceiptVoucherListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetReceiptVoucherListDataUserDTO extends Data
{
    public function __construct(
        // user
        public ?string $group_filter,
        public ?array $search_filter_list,
        public ?string $search_phrase,
        public int $page_size,
        public int $page,
        // system

    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
