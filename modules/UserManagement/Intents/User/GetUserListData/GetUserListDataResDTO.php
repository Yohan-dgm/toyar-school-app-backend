<?php

namespace Modules\UserManagement\Intents\User\GetUserListData;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetUserListDataResDTO extends Data
{
    public function __construct(
        // user

        // system
        public ?array $data,
        // public int $total,
        public ?object $user_count,

    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user

            // system
        ];
    }
}
