<?php

namespace Modules\SectionAccessManagement\Intents\RevokeSectionAccess;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class RevokeSectionAccessUserDTO extends Data
{
    public function __construct(
        // user
        public int $user_id,
        public string $section_key,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'user_id' => [new Required, new IntegerType],
            'section_key' => [new Required, new StringType],
            // system
        ];
    }
}
