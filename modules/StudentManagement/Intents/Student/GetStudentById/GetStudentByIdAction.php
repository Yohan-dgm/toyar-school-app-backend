<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentById;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;

class GetStudentByIdAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $getStudentByIdUserDTO = GetStudentByIdUserDTO::validate($payloadArray);

        $studentId = $getStudentByIdUserDTO['student_id'];

        $student = Student::with([
            'grade_level' => function (Builder $query) {
                $query->select('id', 'name');
            },
            'grade_level_class' => function (Builder $query) {
                $query->select('id', 'name', 'grade_level_id');
            },
            'school_house' => function (Builder $query) {
                $query->select('id', 'name');
            },
        ])->find($studentId);

        if (! $student) {
            throw new \Exception('Student not found');
        }

        return [
            'id' => $student->id,
            'admission_number' => $student->admission_number,
            'full_name' => $student->full_name,
            'full_name_with_title' => $student->full_name_with_title,
            'student_calling_name' => $student->student_calling_name,
            'gender' => $student->gender,
            'date_of_birth' => $student->date_of_birth,
            'blood_group' => $student->blood_group,
            'phone' => $student->phone,
            'email' => $student->email,
            'student_phone' => $student->student_phone,
            'student_email' => $student->student_email,
            'full_address' => $student->full_address,
            'student_address' => $student->student_address,
            'joined_date' => $student->joined_date,
            'school_studied_before' => $student->school_studied_before,
            'special_conditions' => $student->special_conditions,
            'special_health_conditions' => $student->special_health_conditions,
            'has_dropped_out' => $student->has_dropped_out,
            'is_school_leaver' => $student->is_school_leaver,
            'is_sport_list' => $student->is_sport_list,
            'grade_level' => $student->grade_level ? [
                'id' => $student->grade_level->id,
                'name' => $student->grade_level->name,
                'description' => $student->grade_level->description,
            ] : null,
            'created_info' => [
                'created_by' => $student->created_by,
                'updated_by' => $student->updated_by,
                'created_at' => $student->created_at?->toISOString(),
                'updated_at' => $student->updated_at?->toISOString(),
            ],
        ];
    }
}
