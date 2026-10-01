<?php

namespace Modules\SectionAccessManagement\Intents\GetGrantableUserList;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetGrantableUserListUserDTO extends Data
{
    public function __construct(
        public ?string $search_phrase,
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            'search_phrase' => [],
        ];
    }
}
