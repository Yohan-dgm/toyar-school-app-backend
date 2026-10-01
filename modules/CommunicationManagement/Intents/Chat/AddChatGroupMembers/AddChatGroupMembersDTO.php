<?php

namespace Modules\CommunicationManagement\Intents\Chat\AddChatGroupMembers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AddChatGroupMembersDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'chat_group_id' => 'required|integer|exists:chat_groups,id',
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'integer|exists:user,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
