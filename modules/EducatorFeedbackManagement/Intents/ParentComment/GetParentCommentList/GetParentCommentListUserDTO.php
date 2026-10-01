<?php

namespace Modules\EducatorFeedbackManagement\Intents\ParentComment\GetParentCommentList;

use Spatie\LaravelData\Data;

class GetParentCommentListUserDTO extends Data
{
    public function __construct(
        public string $edu_fb_id,
    ) {}

    public static function rules(): array
    {
        return [
            'edu_fb_id' => ['required', 'string', 'max:50'],
        ];
    }

    public static function messages(): array
    {
        return [
            'edu_fb_id.required' => 'Educator feedback ID is required',
            'edu_fb_id.string' => 'Educator feedback ID must be a string',
            'edu_fb_id.max' => 'Educator feedback ID must not exceed 50 characters',
        ];
    }
}
