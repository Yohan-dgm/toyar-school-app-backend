<?php

namespace Modules\StudentManagement\Intents\StudentSport\CreateStudentSport;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;
use Modules\StudentManagement\Models\StudentSport;

class CreateStudentSportAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createStudentSportUserDTO = CreateStudentSportUserDTO::validate($payloadArray);

        // Data Prep

        // $student = Student::where(function (Builder $student_query_group1,) use ($createStudentSportUserDTO) {
        //     $student_query_group1->where("id", "=",  $createStudentSportUserDTO['student_id']);
        // })->get()->first();

        // var dump student_sport_list
        // $studentSportList = $createStudentSportUserDTO['student_sport_list'] ?? [];

        // var_dump($createStudentSportUserDTO['student_sport_list']);
        // var_dump($createStudentSportUserDTO['student_id']);
        // die();
        $student = Student::where('id', $createStudentSportUserDTO['student_id'])->get()->first();

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        $studentSportList = $createStudentSportUserDTO['student_sport_list'] ?? [];
        foreach ($studentSportList as $item) {

            // System Data Validation
            $createStudentSportSystemDTO = CreateStudentSportSystemDTO::validate($system_data);

            // Final Data Validation
            $createStudentSportDTO = CreateStudentSportDTO::validate(array_merge($createStudentSportUserDTO, $createStudentSportSystemDTO));

            $createStudentSportDTO['sport_id'] = $item['id'];
            // Save In Database
            $createStudentSport = StudentSport::create($createStudentSportDTO);

            $studentSport = StudentSport::where('id', $createStudentSport->id)->get()->first();
        }

        //update student table is_sport_list to true where id = $createStudentSportUserDTO['student_id']
        $student->update(['is_sport_list' => true]);

        return $studentSport;
    }
}
