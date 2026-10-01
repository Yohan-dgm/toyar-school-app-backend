<?php

namespace Modules\UserManagement\Intents\UserPushToken\RegisterPushToken;

use Spatie\LaravelData\Data;

class RegisterPushTokenResDTO extends Data
{
    public function __construct(
        public int $id,
        public int $user_id,
        public string $device_id,
        public string $platform,
        public bool $is_active,
        public bool $was_updated,
        public string $created_at,
        public string $updated_at,
    ) {}
}