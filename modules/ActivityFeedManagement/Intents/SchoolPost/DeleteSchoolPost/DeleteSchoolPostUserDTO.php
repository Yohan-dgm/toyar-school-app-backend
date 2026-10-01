<?php

namespace Modules\ActivityFeedManagement\Intents\SchoolPost\DeleteSchoolPost;

use Spatie\LaravelData\Data;

class DeleteSchoolPostUserDTO extends Data
{
    public function __construct(
        public int $id,
    ) {}
}
