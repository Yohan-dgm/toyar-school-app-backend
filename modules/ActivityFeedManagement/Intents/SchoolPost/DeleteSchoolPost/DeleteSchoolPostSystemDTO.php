<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\DeleteSchoolPost;

use Spatie\LaravelData\Data;

class DeleteSchoolPostSystemDTO extends Data
{
    public function __construct(
        public int $user_id,
    ) {}
}
