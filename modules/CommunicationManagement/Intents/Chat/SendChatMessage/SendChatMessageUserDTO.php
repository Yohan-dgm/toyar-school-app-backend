<?php

namespace Modules\CommunicationManagement\Intents\Chat\SendChatMessage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SendChatMessageUserDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'chat_group_id' => 'required|integer|exists:chat_groups,id',
            'type' => 'required|string|in:text,image,file',
            'content' => 'required_if:type,text|string|nullable',
            'attachment' => 'nullable|file|max:51200', // 50MB max
            'attachment_url' => 'nullable|string',
            'metadata' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
