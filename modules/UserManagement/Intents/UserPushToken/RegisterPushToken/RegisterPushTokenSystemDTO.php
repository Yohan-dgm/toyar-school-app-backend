<?php

namespace Modules\UserManagement\Intents\UserPushToken\RegisterPushToken;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class RegisterPushTokenSystemDTO extends Data
{
    public function __construct(
        #[Required]
        public int $user_id,
    ) {}
}