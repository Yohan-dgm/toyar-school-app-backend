<?php

namespace Modules\AccountManagement\Intents\SportFeeInvoice\GetSportFeeInvoiceListData;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetSportFeeInvoiceListDataUserDTO extends Data
{
    public function __construct(
        // user
        public int $student_id,
        public ?string $group_filter,
        public ?array $search_filter_list,
        public ?string $search_phrase,
        public ?int $page_size,
        public ?int $page,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'student_id,    ' => [new Required, new IntegerType],
            // system
        ];
    }
}
