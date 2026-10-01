<?php

namespace Modules\CommunicationManagement\Intents\Chat\GetChatThreads;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GetChatThreadsUserDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'page' => 'nullable|integer|min:1',
            'per_page' => 'nullable|integer|min:1|max:100',
            'search' => 'nullable|string|max:100',
            'type' => 'nullable|string|in:direct,group,all',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
