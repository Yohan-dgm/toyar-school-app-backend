<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatMessages;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GetChatMessagesUserDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'chat_group_id' => 'required|integer|exists:chat_groups,id',
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
