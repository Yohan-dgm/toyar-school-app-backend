<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\BulkCreateSportTimetable;

class BulkCreateSportTimetableUserDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'sport_timetables' => 'required|array|min:1',
            'sport_timetables.*.sport_id' => 'required|integer|exists:sport,id',
            'sport_timetables.*.grade_level_class_id' => 'nullable|integer|exists:grade_level_class,id',
            'sport_timetables.*.coach_id' => 'required|integer|exists:employee,id',
            'sport_timetables.*.day_of_week' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'sport_timetables.*.start_time' => 'required|date_format:H:i:s',
            'sport_timetables.*.end_time' => 'required|date_format:H:i:s|after:sport_timetables.*.start_time',
            'sport_timetables.*.venue' => 'nullable|string|max:100',
            'sport_timetables.*.facility' => 'nullable|string|max:100',
            'sport_timetables.*.season' => 'required|string|in:spring,summer,autumn,winter,all_year',
            'sport_timetables.*.academic_year' => 'required|string|max:20',
            'sport_timetables.*.is_active' => 'boolean',
            'sport_timetables.*.notes' => 'nullable|string|max:1000',
            'sport_timetables.*.team_id' => 'nullable|integer',
            'sport_timetables.*.max_participants' => 'nullable|integer|min:1',
            'sport_timetables.*.age_group' => 'nullable|string|max:50',
            'sport_timetables.*.skill_level' => 'nullable|string|in:beginner,intermediate,advanced,expert',
        ];

        $messages = [
            'sport_timetables.required' => 'Sport timetables array is required.',
            'sport_timetables.array' => 'Sport timetables must be an array.',
            'sport_timetables.min' => 'At least one sport timetable record is required.',
            'sport_timetables.*.sport_id.required' => 'Sport is required for each record.',
            'sport_timetables.*.sport_id.exists' => 'Selected sport does not exist.',
            'sport_timetables.*.grade_level_class_id.exists' => 'Selected grade level class does not exist.',
            'sport_timetables.*.coach_id.required' => 'Coach is required for each record.',
            'sport_timetables.*.coach_id.exists' => 'Selected coach does not exist.',
            'sport_timetables.*.day_of_week.required' => 'Day of week is required for each record.',
            'sport_timetables.*.day_of_week.in' => 'Day of week must be a valid day.',
            'sport_timetables.*.start_time.required' => 'Start time is required for each record.',
            'sport_timetables.*.start_time.date_format' => 'Start time must be in HH:MM:SS format.',
            'sport_timetables.*.end_time.required' => 'End time is required for each record.',
            'sport_timetables.*.end_time.date_format' => 'End time must be in HH:MM:SS format.',
            'sport_timetables.*.end_time.after' => 'End time must be after start time.',
            'sport_timetables.*.season.required' => 'Season is required for each record.',
            'sport_timetables.*.season.in' => 'Season must be a valid season.',
            'sport_timetables.*.academic_year.required' => 'Academic year is required for each record.',
            'sport_timetables.*.max_participants.integer' => 'Max participants must be a number.',
            'sport_timetables.*.max_participants.min' => 'Max participants must be at least 1.',
            'sport_timetables.*.skill_level.in' => 'Skill level must be a valid level.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($payloadArray, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
