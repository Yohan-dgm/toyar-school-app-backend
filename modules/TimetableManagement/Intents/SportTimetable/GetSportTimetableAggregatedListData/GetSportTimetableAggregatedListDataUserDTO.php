<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\GetSportTimetableAggregatedListData;

class GetSportTimetableAggregatedListDataUserDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'sport_id' => 'nullable|integer|exists:sport,id',
            'coach_id' => 'nullable|integer|exists:employee,id',
            'season' => 'nullable|string|in:spring,summer,autumn,winter,all_year',
            'academic_year' => 'nullable|string|max:20',
            'skill_level' => 'nullable|string|in:beginner,intermediate,advanced,expert',
            'day_of_week' => 'nullable|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];

        $messages = [
            'sport_id.exists' => 'Selected sport does not exist.',
            'coach_id.exists' => 'Selected coach does not exist.',
            'season.in' => 'Season must be a valid season.',
            'skill_level.in' => 'Skill level must be a valid level.',
            'day_of_week.in' => 'Day of week must be a valid day.',
            'per_page.integer' => 'Per page must be a number.',
            'per_page.min' => 'Per page must be at least 1.',
            'per_page.max' => 'Per page cannot exceed 100.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($payloadArray, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
