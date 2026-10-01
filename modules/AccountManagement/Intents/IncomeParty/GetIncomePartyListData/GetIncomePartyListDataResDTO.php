<?php

namespace Modules\AccountManagement\Intents\IncomeParty\GetIncomePartyListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetIncomePartyListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $income_party_count,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
