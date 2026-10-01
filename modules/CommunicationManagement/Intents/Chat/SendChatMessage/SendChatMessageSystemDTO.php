<?php

namespace Modules\CommunicationManagement\Intents\Chat\SendChatMessage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SendChatMessageSystemDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:user,id',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
