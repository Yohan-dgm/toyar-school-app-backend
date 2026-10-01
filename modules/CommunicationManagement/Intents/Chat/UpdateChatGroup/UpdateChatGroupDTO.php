<?php

namespace Modules\CommunicationManagement\Intents\Chat\UpdateChatGroup;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UpdateChatGroupDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'chat_group_id' => 'required|integer|exists:chat_groups,id',
            'name' => 'nullable|string|max:100',
            'avatar_url' => 'nullable|string|max:500',
            'is_disabled' => 'nullable|boolean',
            'only_admins_can_message' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
