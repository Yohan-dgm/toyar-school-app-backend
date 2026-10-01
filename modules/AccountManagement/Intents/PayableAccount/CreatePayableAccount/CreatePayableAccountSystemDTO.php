<?php

namespace Modules\AccountManagement\Intents\PayableAccount\CreatePayableAccount;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreatePayableAccountSystemDTO extends Data
{
    public function __construct(
        public int $created_by
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
