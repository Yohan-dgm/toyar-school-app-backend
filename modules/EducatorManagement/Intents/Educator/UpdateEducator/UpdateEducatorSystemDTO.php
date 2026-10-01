<?php

namespace Modules\EducatorManagement\Intents\Educator\UpdateEducator;

use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateEducatorSystemDTO extends Data
{
    public function __construct(
        // system
        public bool $is_active,
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        // $requestArray = $request->all();
        // $name_temp =  $context->fullPayload['name'];
        return [
            // system
            'is_active' => [new Required, new BooleanType],
            'updated_by' => [new Required, new IntegerType],
        ];
    }
}
