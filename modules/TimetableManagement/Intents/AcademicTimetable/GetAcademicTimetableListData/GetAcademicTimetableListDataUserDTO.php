<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\GetAcademicTimetableListData;

class GetAcademicTimetableListDataUserDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'grade_level_class_id' => 'nullable|integer|exists:grade_level_class,id',
            'subject_id' => 'nullable|integer|exists:subject,id',
            'educator_id' => 'nullable|integer|exists:educators,id',
            'day_of_week' => 'nullable|string|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'semester' => 'nullable|string|max:50',
            'academic_year' => 'nullable|string|max:20',
            'is_active' => 'nullable|boolean',
            'building' => 'nullable|string|max:100',
            'room_number' => 'nullable|string|max:50',
            'per_page' => 'nullable|integer|min:1|max:100',
        ];

        $messages = [
            'grade_level_class_id.exists' => 'Selected grade level class does not exist.',
            'subject_id.exists' => 'Selected subject does not exist.',
            'educator_id.exists' => 'Selected educator does not exist.',
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
