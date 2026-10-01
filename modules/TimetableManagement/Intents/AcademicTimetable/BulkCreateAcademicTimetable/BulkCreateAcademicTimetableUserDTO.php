<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\BulkCreateAcademicTimetable;

class BulkCreateAcademicTimetableUserDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'academic_timetables' => 'required|array|min:1',
            'academic_timetables.*.grade_level_class_id' => 'required|integer|exists:grade_level_class,id',
            'academic_timetables.*.subject_id' => 'required|integer|exists:subject,id',
            'academic_timetables.*.educator_id' => 'required|integer|exists:educators,id',
            'academic_timetables.*.day_of_week' => 'required|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'academic_timetables.*.start_time' => 'required|date_format:H:i:s',
            'academic_timetables.*.end_time' => 'required|date_format:H:i:s|after:academic_timetables.*.start_time',
            'academic_timetables.*.room_number' => 'nullable|string|max:50',
            'academic_timetables.*.building' => 'nullable|string|max:100',
            'academic_timetables.*.semester' => 'required|string|max:50',
            'academic_timetables.*.academic_year' => 'required|string|max:20',
            'academic_timetables.*.is_active' => 'boolean',
            'academic_timetables.*.notes' => 'nullable|string|max:1000',
        ];

        $messages = [
            'academic_timetables.required' => 'Academic timetables array is required.',
            'academic_timetables.array' => 'Academic timetables must be an array.',
            'academic_timetables.min' => 'At least one academic timetable record is required.',
            'academic_timetables.*.grade_level_class_id.required' => 'Grade level class is required for each record.',
            'academic_timetables.*.grade_level_class_id.exists' => 'Selected grade level class does not exist.',
            'academic_timetables.*.subject_id.required' => 'Subject is required for each record.',
            'academic_timetables.*.subject_id.exists' => 'Selected subject does not exist.',
            'academic_timetables.*.educator_id.required' => 'Educator is required for each record.',
            'academic_timetables.*.educator_id.exists' => 'Selected educator does not exist.',
            'academic_timetables.*.day_of_week.required' => 'Day of week is required for each record.',
            'academic_timetables.*.day_of_week.in' => 'Day of week must be a valid day.',
            'academic_timetables.*.start_time.required' => 'Start time is required for each record.',
            'academic_timetables.*.start_time.date_format' => 'Start time must be in HH:MM:SS format.',
            'academic_timetables.*.end_time.required' => 'End time is required for each record.',
            'academic_timetables.*.end_time.date_format' => 'End time must be in HH:MM:SS format.',
            'academic_timetables.*.end_time.after' => 'End time must be after start time.',
            'academic_timetables.*.semester.required' => 'Semester is required for each record.',
            'academic_timetables.*.academic_year.required' => 'Academic year is required for each record.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($payloadArray, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
