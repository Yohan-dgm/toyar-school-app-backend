<?php

namespace Modules\AccountManagement\Intents\ReceiptVoucher\DeleteReceiptVoucher;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class DeleteReceiptVoucherDTO extends Data
{
    public function __construct(
        // user
        public int $id,

        // system
        public bool $is_active,
        public int $deleted_by,
        public Date $deleted_date,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'id' => [new Required, new IntegerType],

            // system
            'is_active' => [new Required, new BooleanType],
            'deleted_by' => [new Required, new IntegerType],
            'deleted_date' => [new Required, new Date],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
