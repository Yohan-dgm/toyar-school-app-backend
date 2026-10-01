<?php

namespace Modules\UserManagement\Intents\UserPushToken\DeletePushToken;

use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Data;

class DeletePushTokenSystemDTO extends Data
{
    public function __construct(
        #[Required]
        public int $user_id,
    ) {}
}