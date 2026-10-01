<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\UpdateAcademicTimetable;

class UpdateAcademicTimetableDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'id' => 'required|integer|exists:academic_timetable,id',
            'updated_by' => 'required|integer|exists:users,id',
            'grade_level_class_id' => 'required|integer|exists:grade_level_class,id',
            'subject_id' => 'required|integer|exists:subject,id',
            'educator_id' => 'required|integer|exists:educators,id',
            'day_of_week' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'room_number' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'semester' => 'required|string|max:50',
            'academic_year' => 'required|string|max:20',
            'is_active' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ];

        $messages = [
            'id.required' => 'Academic timetable ID is required.',
            'id.exists' => 'Selected academic timetable record does not exist.',
            'updated_by.required' => 'Updated by user ID is required.',
            'updated_by.exists' => 'Updated by user does not exist.',
            'grade_level_class_id.required' => 'Grade level class is required.',
            'grade_level_class_id.exists' => 'Selected grade level class does not exist.',
            'subject_id.required' => 'Subject is required.',
            'subject_id.exists' => 'Selected subject does not exist.',
            'educator_id.required' => 'Educator is required.',
            'educator_id.exists' => 'Selected educator does not exist.',
            'day_of_week.required' => 'Day of week is required.',
            'day_of_week.in' => 'Day of week must be a valid day.',
            'start_time.required' => 'Start time is required.',
            'start_time.date_format' => 'Start time must be in HH:MM:SS format.',
            'end_time.required' => 'End time is required.',
            'end_time.date_format' => 'End time must be in HH:MM:SS format.',
            'end_time.after' => 'End time must be after start time.',
            'semester.required' => 'Semester is required.',
            'academic_year.required' => 'Academic year is required.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($payloadArray, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
