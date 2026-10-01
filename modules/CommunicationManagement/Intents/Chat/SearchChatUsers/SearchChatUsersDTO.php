<?php

namespace Modules\CommunicationManagement\Intents\Chat\SearchChatUsers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;

class SearchChatUsersDTO
{
    public static function validate(array $data): array
    {
        $validator = Validator::make($data, [
            'query' => 'nullable|string',
            'filter' => ['nullable', Rule::in(['all', 'teacher', 'student', 'parent', 'management'])],
            'chat_group_id' => 'nullable|integer',
            'per_page' => 'nullable|integer|max:100',
            'page' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
