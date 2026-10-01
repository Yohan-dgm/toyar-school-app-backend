<?php

namespace Modules\AccountManagement\Intents\ReceivableDashboard\CreateReceivableDashboard;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateReceivableDashboardDTO extends Data
{
    public function __construct(
        // user
        public string $name,

        // system
        public int $created_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            'name' => [new Required, new StringType, new Unique('receivable_dashboard', 'name')],

            // system
            'created_by' => [new Required, new IntegerType],
        ];
    }
}
