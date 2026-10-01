<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\CreateStudentAchievement;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;
use Modules\StudentManagement\Models\StudentAchievement;

class CreateStudentAchievementAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $createStudentAchievementUserDTO = CreateStudentAchievementUserDTO::validate($payloadArray);

        $student = Student::where('id', $createStudentAchievementUserDTO['student_id'])->first();

        if (! $student) {
            throw new \Exception('Student not found');
        }

        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        $createStudentAchievementSystemDTO = CreateStudentAchievementSystemDTO::validate($system_data);

        $createStudentAchievementDTO = CreateStudentAchievementDTO::validate(
            array_merge($createStudentAchievementUserDTO, $createStudentAchievementSystemDTO)
        );

        $createStudentAchievement = StudentAchievement::create($createStudentAchievementDTO);

        $studentAchievement = StudentAchievement::where('id', $createStudentAchievement->id)
            ->with(['student'])
            ->first();

        return $studentAchievement;
    }
}
