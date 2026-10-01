<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\RequestDeleteReceiptVoucher;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class RequestDeleteReceiptVoucherUserDTO extends Data
{
    public function __construct(
        // user
        public int $id,
        public string $delete_reason,
        public ?string $name,
        // public mixed $receipt_voucher_delete_unsaved_attachment_list,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],
            'delete_reason' => [new Required, new StringType],
        ];
    }
}
