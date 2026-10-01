<?php

namespace Modules\UserManagement\Intents\User\GetCurrentUserAppUpdateStatus;

use Spatie\LaravelData\Data;

class GetCurrentUserAppUpdateStatusResDTO extends Data
{
    public function __construct(
        public int $user_id,
        public string $username,
        public string $email,
        public ?string $iso_app_version,
        public ?string $android_app_version,
        public bool $is_active,
        public ?string $user_category,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            username: $data['username'] ?? '',
            email: $data['email'] ?? '',
            iso_app_version: $data['iso_app_version'] ?? null,
            android_app_version: $data['android_app_version'] ?? null,
            is_active: $data['is_active'] ?? false,
            user_category: $data['user_category'] ?? null,
        );
    }
}