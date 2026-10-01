<?php

namespace Modules\CommunicationManagement\Intents\Chat\SendChatMessage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SendChatMessageDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'chat_group_id' => 'required|integer',
            'user_id' => 'required|integer',
            'type' => 'required|string',
            'content' => 'nullable|string',
            'attachment' => 'nullable',
            'attachment_url' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
