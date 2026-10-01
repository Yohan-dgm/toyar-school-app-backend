<?php

namespace Modules\AccountManagement\Intents\GeneralBill\GetGeneralBillListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetGeneralBillListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        public int $total,
        public ?object $general_bill_count,
        public ?object $dropped_out_general_bill_count,
        public ?object $incomplete_general_bill_count,
        public ?object $grade_level_general_bill_count,
        public ?object $school_house_general_bill_count,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
