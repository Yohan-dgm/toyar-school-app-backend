<?php

namespace Modules\CommunicationManagement\Intents\Chat\RemoveChatGroupMember;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RemoveChatGroupMemberDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'chat_group_id' => 'required|integer|exists:chat_groups,id',
            'user_id' => 'required|integer|exists:user,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
