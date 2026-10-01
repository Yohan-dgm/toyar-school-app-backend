<?php

namespace Modules\UserManagement\Intents\User\UpdateUser;

use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class UpdateUserDTO extends Data
{
    public function __construct(
        // user 
        public int $id,
        public string $current_password,
        public string $new_password,

        // system
        public int $updated_by,
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            // user    
            "id" =>  [new Required(), new IntegerType()],
            "current_password" =>  [new Required(), new StringType()],
            "new_password" =>  [new Required(), new StringType()],

            // system
            "updated_by" =>  [new Required()],
        ];
    }
}
