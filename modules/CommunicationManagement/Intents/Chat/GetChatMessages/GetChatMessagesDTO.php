<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatMessages;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GetChatMessagesDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'chat_group_id' => 'required|integer',
            'user_id' => 'required|integer',
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
