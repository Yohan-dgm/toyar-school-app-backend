<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\DeleteSchoolPost;

use Spatie\LaravelData\Data;

class DeleteSchoolPostDTO extends Data
{
    public function __construct(
        public int $id,
        public int $user_id,
    ) {}
}
