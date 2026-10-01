<?php

namespace Modules\ActivityFeedManagement\Intents\StudentPost\ToggleLike;

use Spatie\LaravelData\Data;

class ToggleLikeUserDTO extends Data
{
    public function __construct(
        public int $post_id,
        public string $action,
    ) {}

    public static function rules(): array
    {
        return [
            'post_id' => ['required', 'integer', 'min:1'],
            'action' => ['required', 'string', 'in:like,unlike'],
        ];
    }
}
