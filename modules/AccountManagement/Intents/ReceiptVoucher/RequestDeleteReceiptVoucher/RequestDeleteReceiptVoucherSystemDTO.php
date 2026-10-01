<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\RequestDeleteReceiptVoucher;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class RequestDeleteReceiptVoucherSystemDTO extends Data
{
    public function __construct(
        // system
        public int $receipt_voucher_id,
        public int $requested_by,
        public Date $requested_date,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'receipt_voucher_id' => [new Required, new IntegerType],
            'requested_by' => [new Required, new IntegerType],
            'requested_date' => [new Required, new Date],
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
