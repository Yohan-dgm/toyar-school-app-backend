<?php

namespace Modules\UserManagement\Intents\User\CreateUser;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class CreateUserUserDTO extends Data
{
    public function __construct(
        // user
        public string $full_name,
        public string $username,
        public string $email,
        public string $password,
        // system
    ) {}

    public static function rules(Request $request, ValidationContext $context): array
    {
        return [
            // user
            "full_name" => "required|min:2|max:255",
            "username" => "required|alpha_num:ascii|min:3|max:16|unique:user,username",
            "email" => "required|email|max:32|unique:user,email",
            "password" => "required|min:6|max:255",
            // system
        ];
    }
}
