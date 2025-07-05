<?php

namespace Modules\UserManagement\Intents\UserProfile\ChangePassword;

use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class ChangePasswordUserDTO extends Data
{
    public function __construct(
        // user   
        public int $id,
        public string $current_password,
        public string $new_password,
        public string $confirm_password,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user  
            "id" =>  [new Required()],
            "current_password" =>  [new Required(), new StringType()],
            "new_password" =>  [new Required(), new StringType()],
            "confirm_password" =>  [new Required(), new StringType()],
            // system 
        ];
    }
}
