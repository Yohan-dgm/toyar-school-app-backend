<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatThreads;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GetChatThreadsDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|integer',
            'page' => 'nullable|integer',
            'per_page' => 'nullable|integer',
            'search' => 'nullable|string',
            'type' => 'nullable|string',
            'school_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
