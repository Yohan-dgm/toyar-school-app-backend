<?php

namespace Modules\UserManagement\Intents\UserPushToken\DeletePushToken;

use Spatie\LaravelData\Data;

class DeletePushTokenUserDTO extends Data
{
    public function __construct(
        public ?string $device_id = null,
        public ?string $push_token = null,
    ) {}
}