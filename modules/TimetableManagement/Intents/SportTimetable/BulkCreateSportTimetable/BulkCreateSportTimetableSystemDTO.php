<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\BulkCreateSportTimetable;

class BulkCreateSportTimetableSystemDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'created_by' => 'required|integer|exists:users,id',
        ];

        $messages = [
            'created_by.required' => 'Created by user ID is required.',
            'created_by.exists' => 'Created by user does not exist.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($payloadArray, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
