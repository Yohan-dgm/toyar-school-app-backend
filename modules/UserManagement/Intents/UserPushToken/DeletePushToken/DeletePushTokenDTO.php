<?php

namespace Modules\UserManagement\Intents\UserPushToken\DeletePushToken;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class DeletePushTokenDTO extends Data
{
    public function __construct(
        #[Required]
        public int $user_id,

        public ?string $device_id = null,
        public ?string $push_token = null,
    ) {}
}