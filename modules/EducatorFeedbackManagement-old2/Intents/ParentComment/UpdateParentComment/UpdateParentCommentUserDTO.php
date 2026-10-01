<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\UpdateParentComment;

use Spatie\LaravelData\Data;

class UpdateParentCommentUserDTO extends Data
{
    public function __construct(
        public int $id,
        public string $comment,
    ) {}

    public static function rules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:edu_fb_parent_comments,id'],
            'comment' => ['required', 'string', 'min:1'],
        ];
    }

    public static function messages(): array
    {
        return [
            'id.required' => 'Comment ID is required',
            'id.integer' => 'Comment ID must be an integer',
            'id.exists' => 'Comment not found',
            'comment.required' => 'Comment is required',
            'comment.string' => 'Comment must be a string',
            'comment.min' => 'Comment must be at least 1 character',
        ];
    }
}
