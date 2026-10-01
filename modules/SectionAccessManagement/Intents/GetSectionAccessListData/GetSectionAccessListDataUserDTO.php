<?php

namespace Modules\SectionAccessManagement\Intents\GetSectionAccessListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetSectionAccessListDataUserDTO extends Data
{
    public function __construct(
        public string $section_key,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'section_key' => [new Required, new StringType],
        ];
    }
}
