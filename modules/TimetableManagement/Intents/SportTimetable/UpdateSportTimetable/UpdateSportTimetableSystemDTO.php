<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\UpdateSportTimetable;

class UpdateSportTimetableSystemDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'updated_by' => 'required|integer|exists:users,id',
        ];

        $messages = [
            'updated_by.required' => 'Updated by user ID is required.',
            'updated_by.exists' => 'Updated by user does not exist.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($payloadArray, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
