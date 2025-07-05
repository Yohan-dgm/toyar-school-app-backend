<?php

namespace Modules\UserManagement\Intents\UserProfile\ChangePassword;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ChangePasswordSystemDTO extends Data
{
    public function __construct(
        public int $update_by,
        public string $password,
        public string $password_new,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            "update_by" =>  [new Required()],
            "password" =>  [new Required()],
            "password_new" =>  [new Required()],
        ];
    }
}
