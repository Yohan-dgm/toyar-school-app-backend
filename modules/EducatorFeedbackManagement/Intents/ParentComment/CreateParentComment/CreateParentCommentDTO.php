<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\CreateParentComment;

use Spatie\LaravelData\Data;

class CreateParentCommentDTO extends Data
{
    public function __construct(
        public string $edu_fb_id,
        public string $comment,
        public int $created_by,
        public ?int $updated_by = null,
    ) {}
}
