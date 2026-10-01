<?php

namespace Modules\SectionAccessManagement\Intents\GrantSectionAccess;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GrantSectionAccessSystemDTO extends Data
{
    public function __construct(
        public int $granted_by,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'granted_by' => [new Required, new IntegerType],
        ];
    }
}
