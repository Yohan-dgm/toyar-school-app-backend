<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\BulkCreateEducatorAttendance;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\EducatorAttendance;
use Modules\EducatorManagement\Models\Educator;

class BulkCreateEducatorAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $createEducatorAttendanceUserDTO = BulkCreateEducatorAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['created_by'] = $actionData['created_by'];

        // System Data Validation
        $createEducatorAttendanceSystemDTO = BulkCreateEducatorAttendanceSystemDTO::validate($system_data);
        // Final Data Validation
        $createEducatorAttendanceDTO = BulkCreateEducatorAttendanceDTO::validate(array_merge($createEducatorAttendanceUserDTO, $createEducatorAttendanceSystemDTO));

        $educatorListData = Educator::select("id")->get();

        $createEducatorAttendanceDataList = [];
        foreach ($educatorListData as $educatorListData_list) {
            $attendanceData = [
                "educator_id" => $educatorListData_list->id,
                "date" => $createEducatorAttendanceDTO['date'],
                "time" => $createEducatorAttendanceDTO['in_time'],
                "attendance_type_id" => 1,
            ];
            array_push($createEducatorAttendanceDataList, $attendanceData);

            $attendanceData = [
                "educator_id" => $educatorListData_list->id,
                "date" => $createEducatorAttendanceDTO['date'],
                "time" => $createEducatorAttendanceDTO['out_time'],
                "attendance_type_id" => 2,
            ];
            array_push($createEducatorAttendanceDataList, $attendanceData);
        }

        // Save In Database
        $createEducatorAttendanceDataList = array_map(function ($item) use ($createEducatorAttendanceDTO) {
            return array_merge(
                $item,
                [
                    "created_by" => $createEducatorAttendanceDTO['created_by'],
                    'created_at' => Carbon::now(),
                ]
            );
        }, $createEducatorAttendanceDataList);

        $attendance = EducatorAttendance::insert($createEducatorAttendanceDataList);

        return $attendance;
    }
}
