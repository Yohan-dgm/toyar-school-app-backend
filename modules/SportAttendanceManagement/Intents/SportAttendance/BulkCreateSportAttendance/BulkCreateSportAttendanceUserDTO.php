<?php

namespace Modules\SportAttendanceManagement\Intents\SportAttendance\BulkCreateSportAttendance;

class BulkCreateSportAttendanceUserDTO
{
    public static function validate($payloadArray)
    {
        $rules = [
            'sport_attendances' => 'required|array|min:1',
            'sport_attendances.*.student_id' => 'required|integer|exists:students,id',
            'sport_attendances.*.date' => 'required|date',
            'sport_attendances.*.time' => 'required|date_format:H:i:s',
            'sport_attendances.*.attendance_type_id' => 'required|integer|exists:attendance_types,id',
            'sport_attendances.*.notes' => 'nullable|string|max:1000',
            'sport_attendances.*.sport_activity' => 'required|string|max:255',
            'sport_attendances.*.team_id' => 'nullable|integer',
            'sport_attendances.*.coach_id' => 'nullable|integer|exists:users,id',
        ];

        $messages = [
            'sport_attendances.required' => 'Sport attendances array is required.',
            'sport_attendances.array' => 'Sport attendances must be an array.',
            'sport_attendances.min' => 'At least one sport attendance record is required.',
            'sport_attendances.*.student_id.required' => 'Student ID is required for each attendance record.',
            'sport_attendances.*.student_id.exists' => 'Selected student does not exist.',
            'sport_attendances.*.date.required' => 'Date is required for each attendance record.',
            'sport_attendances.*.date.date' => 'Date must be a valid date.',
            'sport_attendances.*.time.required' => 'Time is required for each attendance record.',
            'sport_attendances.*.time.date_format' => 'Time must be in HH:MM:SS format.',
            'sport_attendances.*.attendance_type_id.required' => 'Attendance type is required for each attendance record.',
            'sport_attendances.*.attendance_type_id.exists' => 'Selected attendance type does not exist.',
            'sport_attendances.*.sport_activity.required' => 'Sport activity is required for each attendance record.',
            'sport_attendances.*.coach_id.exists' => 'Selected coach does not exist.',
        ];

        $validator = \Illuminate\Support\Facades\Validator::make($payloadArray, $rules, $messages);

        if ($validator->fails()) {
            throw new \Illuminate\Validation\ValidationException($validator);
        }

        return $validator->validated();
    }
}
