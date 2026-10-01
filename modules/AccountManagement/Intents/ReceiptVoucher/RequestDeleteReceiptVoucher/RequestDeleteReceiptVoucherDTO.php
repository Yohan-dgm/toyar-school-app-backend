<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\RequestDeleteReceiptVoucher;

use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class RequestDeleteReceiptVoucherDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $delete_reason,
        public ?string $name,

        // system
        public int $receipt_voucher_id,
        public int $requested_by,
        public Date $requested_date,
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'delete_reason' => [new Required, new StringType],

            // system
            'receipt_voucher_id' => [new Required, new IntegerType],
            'requested_by' => [new Required, new IntegerType],
            'requested_date' => [new Required, new Date],
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
