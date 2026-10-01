<?php

namespace Modules\CommunicationManagement\Intents\Chat\CreateChatGroup;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CreateChatGroupUserDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'nullable|string|max:100',
            'type' => 'required|string|in:direct,group',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'integer|exists:user,id',
            'avatar_url' => 'nullable|string|max:500',
            'category' => 'nullable|string',
            'grade_level_id' => 'nullable|integer',
            'grade_level_class_id' => 'nullable|integer',
            'student_ids' => 'nullable|array',
            'student_ids.*' => 'integer',
            'is_disabled' => 'nullable|boolean',
            'only_admins_can_message' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
