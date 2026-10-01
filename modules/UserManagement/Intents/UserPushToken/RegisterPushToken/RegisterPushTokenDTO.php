<?php

namespace Modules\UserManagement\Intents\UserPushToken\RegisterPushToken;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Rule;
use Spatie\LaravelData\Data;

class RegisterPushTokenDTO extends Data
{
    public function __construct(
        #[Required]
        public int $user_id,

        #[Required]
        public string $device_id,

        #[Required]
        public string $push_token,

        #[Required, Rule('in:ios,android')]
        public string $platform,

        public ?string $app_version = null,
        public ?string $device_name = null,
        public ?string $device_model = null,
        public ?string $os_version = null,
    ) {}
}