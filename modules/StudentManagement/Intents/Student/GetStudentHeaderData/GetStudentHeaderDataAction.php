<?php

namespace Modules\StudentManagement\Intents\Student\GetStudentHeaderData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ParentManagement\Models\StudentGuardian;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\UserPaymentStudent;

class GetStudentHeaderDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $userDTO = GetStudentHeaderDataUserDTO::validate($payloadArray);
        $studentId = $userDTO['student_id'];
        $user = $actionData['user'];

        // Ownership check — mirrors exactly the query SignInIntent and
        // GetStudentListByUserAction use to decide which students belong to
        // this guardian (UserPaymentStudent.is_active AND UserPayment.is_active),
        // so this endpoint can never return a student outside the app's own
        // "connected students" list.
        $isOwnedByUser = UserPaymentStudent::where('student_id', $studentId)
            ->where('is_active', true)
            ->whereHas('user_payment', function ($paymentQuery) use ($user) {
                $paymentQuery->where('user_id', $user->id)
                    ->where('is_active', true);
            })
            ->exists();

        if (! $isOwnedByUser) {
            abort(403, 'This student is not linked to your account.');
        }

        $student = Student::with([
            'grade_level' => fn (Builder $query) => $query->select('id', 'name'),
            'grade_level_class' => fn (Builder $query) => $query->select('id', 'name', 'grade_level_id'),
            'school_house' => fn (Builder $query) => $query->select('id', 'name'),
            'student_attachment_list:id,student_id,file_name,original_file_name,mime_type,created_at',
        ])->find($studentId);

        if (! $student) {
            abort(404, 'Student not found.');
        }

        // Guardian info — same relationship-type lookup SignInIntent uses.
        $guardianInfo = null;
        foreach (StudentGuardian::where('user_id', $user->id)->get() as $guardian) {
            $relationshipType = match (true) {
                $student->father_id == $guardian->id => 'father',
                $student->mother_id == $guardian->id => 'mother',
                $student->guardian_id == $guardian->id => 'guardian',
                default => null,
            };

            if ($relationshipType) {
                $guardianInfo = [
                    'guardian_id' => $guardian->id,
                    'guardian_type' => $guardian->guardian_type,
                    'guardian_type_text' => ucfirst($relationshipType),
                    'relationship_type' => $relationshipType,
                    'guardian_full_name' => $guardian->full_name,
                    'guardian_nic_number' => $guardian->nic_number,
                    'guardian_passport_number' => $guardian->passport_number,
                    'guardian_phone' => $guardian->phone,
                    'guardian_whatsapp' => $guardian->whatsapp,
                    'guardian_email' => $guardian->email,
                    'guardian_occupation' => $guardian->occupation,
                    'guardian_place_of_work' => $guardian->place_of_work,
                    'guardian_monthly_income' => $guardian->monthly_income,
                    'guardian_user_id' => $guardian->user_id,
                ];
                break;
            }
        }

        $attachments = [];
        foreach ($student->student_attachment_list ?? [] as $attachment) {
            $attachments[] = [
                'id' => $attachment->id,
                'file_name' => $attachment->file_name,
                'original_file_name' => $attachment->original_file_name,
                'mime_type' => $attachment->mime_type,
                'created_at' => $attachment->created_at,
            ];
        }

        $studentData = $student->toArray();
        $studentData['guardian_info'] = $guardianInfo;
        $studentData['attachments'] = $attachments;

        return $studentData;
    }
}
