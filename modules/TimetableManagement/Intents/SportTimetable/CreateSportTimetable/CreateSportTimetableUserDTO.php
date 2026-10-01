<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\CreateSportTimetable;

class CreateSportTimetableUserDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'sport_id' => 'required|integer|exists:sport,id',
            'grade_level_class_id' => 'nullable|integer|exists:grade_level_class,id',
            'coach_id' => 'required|integer|exists:employee,id',
            'day_of_week' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'venue' => 'nullable|string|max:100',
            'facility' => 'nullable|string|max:100',
            'season' => 'required|string|in:spring,summer,autumn,winter,all_year',
            'academic_year' => 'required|string|max:20',
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:1000',
            'team_id' => 'nullable|integer',
            'max_participants' => 'nullable|integer|min:1',
            'age_group' => 'nullable|string|max:50',
            'skill_level' => 'nullable|string|in:beginner,intermediate,advanced,expert',
        ];

        $messages = [
            'sport_id.required' => 'Sport is required.',
            'sport_id.exists' => 'Selected sport does not exist.',
            'grade_level_class_id.exists' => 'Selected grade level class does not exist.',
            'coach_id.required' => 'Coach is required.',
            'coach_id.exists' => 'Selected coach does not exist.',
            'day_of_week.required' => 'Day of week is required.',
            'day_of_week.in' => 'Day of week must be a valid day.',
            'start_time.required' => 'Start time is required.',
            'start_time.date_format' => 'Start time must be in HH:MM:SS format.',
            'end_time.required' => 'End time is required.',
            'end_time.date_format' => 'End time must be in HH:MM:SS format.',
            'end_time.after' => 'End time must be after start time.',
            'season.required' => 'Season is required.',
            'season.in' => 'Season must be a valid season.',
            'academic_year.required' => 'Academic year is required.',
            'max_participants.integer' => 'Max participants must be a number.',
            'max_participants.min' => 'Max participants must be at least 1.',
            'skill_level.in' => 'Skill level must be a valid level.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($payloadArray, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
