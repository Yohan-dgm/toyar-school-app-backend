<?php

namespace Modules\CommunicationManagement\Intents\Notification\GetNotificationUserTypeListData;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\ParentManagement\Models\StudentGuardian;
use Modules\StudentManagement\Models\Student;
use Modules\UserManagement\Models\User;

class GetNotificationUserTypeListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {

        if (isset($payloadArray['student_id'])) {

            $student = Student::select('father_id', 'mother_id', 'guardian_id')
                ->where('id', $payloadArray['student_id'])
                ->where('has_dropped_out', false)
                ->where('is_school_leaver', false)
                ->first();

            if (!$student) {
                return collect();
            }

            // Collect guardian IDs
            $guardianIds = collect([
                $student->father_id,
                $student->mother_id,
                $student->guardian_id,
            ])->filter()->unique();

            if ($guardianIds->isEmpty()) {
                return collect();
            }

            // Resolve user IDs
            $userIds = StudentGuardian::whereIn('id', $guardianIds)
                ->pluck('user_id')
                ->filter()
                ->unique();

            if ($userIds->isEmpty()) {
                return collect();
            }

            // Return parent users
            return User::whereIn('id', $userIds)
                ->where('is_active', true)
                ->select(
                    'id',
                    'username'
                )
                ->orderBy('id', 'asc')
                ->get();
        }

        $getNotificationUserTypeListDataUserDTO =
            GetNotificationUserTypeListDataUserDTO::validate($payloadArray);

        $userList = User::where(function (Builder $query) use ($getNotificationUserTypeListDataUserDTO) {

            if (
                array_key_exists('group_filter', $getNotificationUserTypeListDataUserDTO) &&
                $getNotificationUserTypeListDataUserDTO['group_filter'] === 'All'
            ) {
                $query->where('is_active', true); //All active users
            } elseif ($getNotificationUserTypeListDataUserDTO['group_filter'] === 'Educator') {
                $query->where('is_active', true)
                    ->where('user_category', 2); // Educators
            } elseif ($getNotificationUserTypeListDataUserDTO['group_filter'] === 'Management') {
                $query->where('is_active', true)
                    ->where('user_category', 4); // Management
            } //Grade Level
            elseif (
                $getNotificationUserTypeListDataUserDTO['group_filter'] === 'Grade_Level'
            ) {
                // Get students in grade
                $students = Student::where('grade_level_id', $getNotificationUserTypeListDataUserDTO['grade_level_id'])
                    ->where('has_dropped_out', false)
                    ->where('is_school_leaver', false)
                    ->select('father_id', 'mother_id', 'guardian_id')
                    ->get();

                // Collect guardian IDs (student_guardians.id)
                $guardianIds = $students->flatMap(function ($student) {
                    return [
                        $student->father_id,
                        $student->mother_id,
                        $student->guardian_id,
                    ];
                })
                    ->filter()
                    ->unique()
                    ->values();

                // Get user IDs from student_guardians
                $userId = StudentGuardian::whereIn('id', $guardianIds)
                    ->pluck('user_id')
                    ->filter()
                    ->unique()
                    ->values();

                // Filter users
                if ($userId->isNotEmpty()) {
                    $query->whereIn('id', $userId)
                        ->where('is_active', true);
                } else {
                    // Prevent returning all users
                    $query->whereRaw('1 = 0');
                }
            }
            //Grade Level class
            elseif ($getNotificationUserTypeListDataUserDTO['group_filter'] === 'Grade_Level_class') {
                $students = Student::where(
                    'grade_level_class_id',
                    $getNotificationUserTypeListDataUserDTO['grade_level_class_id']
                )
                    ->where('has_dropped_out', false)
                    ->where('is_school_leaver', false)
                    ->select('father_id', 'mother_id', 'guardian_id')
                    ->get();

                // Collect guardian IDs
                $guardianIds = $students->flatMap(function ($student) {
                    return [
                        $student->father_id,
                        $student->mother_id,
                        $student->guardian_id,
                    ];
                })
                    ->filter()
                    ->unique()
                    ->values();

                // Get user IDs from StudentGuardian
                $userIds = StudentGuardian::whereIn('id', $guardianIds)
                    ->pluck('user_id')
                    ->filter()
                    ->unique()
                    ->values();

                // Apply to query
                if ($userIds->isNotEmpty()) {
                    $query->whereIn('id', $userIds)
                        ->where('is_active', true);
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
            // EY/ Primary/ Secondary
            elseif (in_array($getNotificationUserTypeListDataUserDTO['group_filter'], ['Early_Years', 'Primary', 'Secondary'])) {

                // Map group names to grade level IDs
                $gradeLevelGroups = [
                    'Early_Years' => [13, 14, 15],
                    'Primary' => [1, 2, 3, 4, 5],
                    'Secondary' => [6, 7, 8, 9, 10, 11, 12],
                ];
                $selectedGroup = $getNotificationUserTypeListDataUserDTO['group_filter'];
                $gradeLevelIds = $gradeLevelGroups[$selectedGroup] ?? [];

                if (empty($gradeLevelIds)) {
                    $query->whereRaw('1 = 0'); // no grades matched
                    return;
                }

                // Get students in these grade levels (not dropped out / not school leavers)
                $students = Student::whereIn('grade_level_id', $gradeLevelIds)
                    ->where('has_dropped_out', false)
                    ->where('is_school_leaver', false)
                    ->select('father_id', 'mother_id', 'guardian_id')
                    ->get();

                // Collect guardian IDs
                $guardianIds = $students->flatMap(function ($student) {
                    return [
                        $student->father_id,
                        $student->mother_id,
                        $student->guardian_id,
                    ];
                })
                    ->filter()
                    ->unique()
                    ->values();

                // Get user IDs from StudentGuardian
                $userIds = StudentGuardian::whereIn('id', $guardianIds)
                    ->pluck('user_id')
                    ->filter()
                    ->unique()
                    ->values();

                // Apply filter to User query
                if ($userIds->isNotEmpty()) {
                    $query->whereIn('id', $userIds)
                        ->where('is_active', true);
                } else {
                    $query->whereRaw('1 = 0');
                }
            }
        })->where(function (Builder $query) use ($getNotificationUserTypeListDataUserDTO) {

            // search_phrase
            if (
                array_key_exists('search_phrase', $getNotificationUserTypeListDataUserDTO) &&
                $getNotificationUserTypeListDataUserDTO['search_phrase'] !== ""
            ) {
                $query->where('name', 'ILIKE', '%' . $getNotificationUserTypeListDataUserDTO['search_phrase'] . '%');
            }
        })
            ->select(
                'id',
                'username',
                'user_category',
                'is_active'
            )
            ->orderBy('id', 'asc')
            ->get();

        return $userList;
    }
}
