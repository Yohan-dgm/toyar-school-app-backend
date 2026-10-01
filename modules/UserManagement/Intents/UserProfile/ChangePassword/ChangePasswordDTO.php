<?php

namespace Modules\UserManagement\Intents\UserProfile\ChangePassword;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ChangePasswordDTO extends Data
{
    public function __construct(
        // user 
        public int $id,
        public string $current_password,
        public string $new_password,
        public string $confirm_password,

        // system
        public int $update_by,
        public string $password,
        public string $password_new,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user    
            "id" =>  [new Required(), new IntegerType()],
            "current_password" =>  [new Required(), new StringType()],
            "new_password" =>  [new Required(), new StringType()],
            "confirm_password" =>  [new Required(), new StringType()],

            // system
            "update_by" =>  [new Required()],
            "password" =>  [new Required()],
            "password_new" =>  [new Required()],
        ];
    }
}
