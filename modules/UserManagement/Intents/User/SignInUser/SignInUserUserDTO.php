<?php

namespace Modules\UserManagement\Intents\User\SignInUser;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class SignInUserUserDTO extends Data
{
    public function __construct(
        // user
        public string $username_or_email,
        public string $password,
        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user
            "username_or_email" => "required",
            "password" => "required",
            // system
        ];
    }
}
