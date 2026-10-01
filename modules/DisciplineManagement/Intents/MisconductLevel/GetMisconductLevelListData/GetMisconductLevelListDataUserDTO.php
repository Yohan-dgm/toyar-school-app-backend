<?php

namespace Modules\DisciplineManagement\Intents\MisconductLevel\GetMisconductLevelListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetMisconductLevelListDataUserDTO extends Data
{
    public function __construct(
        // user
        public ?bool $include_inactive,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            'include_inactive' => [],
            // system
        ];
    }
}
