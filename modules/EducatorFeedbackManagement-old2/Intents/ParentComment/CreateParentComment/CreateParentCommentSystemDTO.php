<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\CreateParentComment;

use Spatie\LaravelData\Data;

class CreateParentCommentSystemDTO extends Data
{
    public function __construct(
        public int $created_by,
        public ?int $updated_by = null,
    ) {}
}
