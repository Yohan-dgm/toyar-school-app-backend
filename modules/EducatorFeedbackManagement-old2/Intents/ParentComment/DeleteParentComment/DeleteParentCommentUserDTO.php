<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\DeleteParentComment;

use Spatie\LaravelData\Data;

class DeleteParentCommentUserDTO extends Data
{
    public function __construct(
        public int $id,
    ) {}

    public static function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:edu_fb_parent_comments,id'],
        ];
    }

    public static function messages(): array
    {
        return [
            'id.required' => 'Comment ID is required',
            'id.integer' => 'Comment ID must be an integer',
            'id.exists' => 'Comment not found',
        ];
    }
}
