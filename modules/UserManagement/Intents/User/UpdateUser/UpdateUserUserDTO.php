<?php

namespace Modules\UserManagement\Intents\User\UpdateUser;

use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class UpdateUserUserDTO extends Data
{
    public function __construct(
        // user   
        public int $id,
        public string $current_password,
        public string $new_password,

        // system
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user  
            "id" =>  [new Required()],
            "current_password" =>  [new Required(), new StringType()],
            "new_password" =>  [new Required(), new StringType()],
            // system 
        ];
    }
}
