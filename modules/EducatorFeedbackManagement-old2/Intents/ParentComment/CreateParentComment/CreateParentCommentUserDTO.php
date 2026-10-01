<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\CreateParentComment;

use Spatie\LaravelData\Data;

class CreateParentCommentUserDTO extends Data
{
    public function __construct(
        public string $edu_fb_id,
        public string $comment,
    ) {}

    public static function rules(): array
    {
        return [
            'edu_fb_id' => ['required', 'string', 'max:50'],
            'comment' => ['required', 'string', 'min:1'],
        ];
    }

    public static function messages(): array
    {
        return [
            'edu_fb_id.required' => 'Educator feedback ID is required',
            'edu_fb_id.string' => 'Educator feedback ID must be a string',
            'edu_fb_id.max' => 'Educator feedback ID must not exceed 50 characters',
            'comment.required' => 'Comment is required',
            'comment.string' => 'Comment must be a string',
            'comment.min' => 'Comment must be at least 1 character',
        ];
    }
}
