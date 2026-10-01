<?php

namespace Modules\StudentManagement\Intents\StudentSport\UpdateStudentSport;

use Illuminate\Support\Facades\DB;
use Modules\StudentManagement\Models\StudentSport;

class UpdateStudentSportAction
{
    use \Lorisleiva\Actions\Concerns\AsAction;

    public function handle(array $payloadArray, array $actionData): bool
    {
        $userDTO = UpdateStudentSportUserDTO::validate($payloadArray);

        try {
            DB::beginTransaction();

            // Get the created_by value for the student
            $createdBy = StudentSport::where('student_id', $userDTO['student_id'])
                ->value('created_by') ?? $actionData['updated_by'];

            // Delete existing records for the student
            StudentSport::where('student_id', $userDTO['student_id'])->delete();

            // Prepare and insert new student sport records
            $studentSportList = $userDTO['student_sport_list'] ?? [];

            foreach ($studentSportList as $item) {
                StudentSport::create([
                    'sport_id' => $item['id'],
                    'student_id' => $userDTO['student_id'],
                    'created_by' => $createdBy,
                    'updated_by' => $actionData['updated_by'],
                ]);
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e; // Or handle the error as per your application's needs
        }
    }
}
