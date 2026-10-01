<?php

namespace Modules\EducatorManagement\Intents\Educator\CreateEducator;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateEducatorSystemDTO extends Data
{
    public function __construct(
        // system
        public int $created_by,
        public bool $is_active,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'created_by' => [new Required, new IntegerType],
            'is_active' => [new Required, new BooleanType],
        ];
    }
}
