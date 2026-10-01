<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatThreads;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GetChatThreadsSystemDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer|exists:user,id',
            'school_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
