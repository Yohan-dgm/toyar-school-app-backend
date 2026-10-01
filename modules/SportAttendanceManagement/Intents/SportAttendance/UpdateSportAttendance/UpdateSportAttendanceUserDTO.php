<?php

namespace Modules\SportAttendanceManagement\Intents\SportAttendance\UpdateSportAttendance;

class UpdateSportAttendanceUserDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'id' => 'required|integer|exists:sport_attendance,id',
            'student_id' => 'required|integer|exists:students,id',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i:s',
            'attendance_type_id' => 'required|integer|exists:attendance_types,id',
            'notes' => 'nullable|string|max:1000',
            'sport_activity' => 'required|string|max:255',
            'team_id' => 'nullable|integer',
            'coach_id' => 'nullable|integer|exists:users,id',
        ];

        $messages = [
            'id.required' => 'Sport attendance ID is required.',
            'id.exists' => 'Selected sport attendance record does not exist.',
            'student_id.required' => 'Student ID is required.',
            'student_id.exists' => 'Selected student does not exist.',
            'date.required' => 'Date is required.',
            'date.date' => 'Date must be a valid date.',
            'time.required' => 'Time is required.',
            'time.date_format' => 'Time must be in HH:MM:SS format.',
            'attendance_type_id.required' => 'Attendance type is required.',
            'attendance_type_id.exists' => 'Selected attendance type does not exist.',
            'sport_activity.required' => 'Sport activity is required.',
            'coach_id.exists' => 'Selected coach does not exist.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($payloadArray, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
