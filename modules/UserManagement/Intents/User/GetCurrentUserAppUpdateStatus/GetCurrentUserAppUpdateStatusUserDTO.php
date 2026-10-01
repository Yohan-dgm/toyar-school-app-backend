<?php

namespace Modules\UserManagement\Intents\User\GetCurrentUserAppUpdateStatus;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class GetCurrentUserAppUpdateStatusUserDTO extends Data
{
    public function __construct()
    {
        // No input parameters needed - uses current authenticated user
    }

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // No validation rules needed
        ];
    }
}