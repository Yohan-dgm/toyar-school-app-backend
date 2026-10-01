<?php

namespace Modules\LogManagement\Intents\InvoicesLog\CreateInvoicesLog;

use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateInvoicesLogUserDTO extends Data
{
    public function __construct(
        // user
        public ?string $description,
        public ?string $user_name,
        public ?string $type,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'description' => [new StringType],
            'user_name' => [new StringType],
            'type' => [new StringType],
        ];
    }
}
