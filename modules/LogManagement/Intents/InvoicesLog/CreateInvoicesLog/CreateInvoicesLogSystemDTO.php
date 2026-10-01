<?php

namespace Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateInvoicesLogSystemDTO extends Data
{
    public function __construct(
        // system
        public ?int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [

            // system
            'created_by' => [new IntegerType],
        ];
    }
}
