<?php

namespace Modules\UserManagement\Intents\UserPushToken\DeletePushToken;

use Spatie\LaravelData\Data;

class DeletePushTokenResDTO extends Data
{
    public function __construct(
        public int $deleted_count,
        public string $message,
    ) {}
}