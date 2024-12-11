<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\EditEducatorAttendance;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\EducatorAttendance;

class EditEducatorAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $editEducatorAttendanceUserDTO = EditEducatorAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $editEducatorAttendanceSystemDTO = EditEducatorAttendanceSystemDTO::validate($system_data);
        // Final Data Validation
        $editEducatorAttendanceDTO = EditEducatorAttendanceDTO::validate(array_merge($editEducatorAttendanceUserDTO, $editEducatorAttendanceSystemDTO));

        // Delete In Database
        EducatorAttendance::where('educator_id', $editEducatorAttendanceDTO['educator_id'])
            ->where('date', $editEducatorAttendanceDTO['date'])->delete();

        // Create In Database
        if ($editEducatorAttendanceDTO['attendance_type'] == 'Absent') {
            $attendanceData = [
                "attendance_type_id" => 4,
                "educator_id" =>  $editEducatorAttendanceDTO['educator_id'],
                "date" => $editEducatorAttendanceDTO['date'],
                "updated_by" => $editEducatorAttendanceDTO['updated_by'],
                'updated_at' => Carbon::now(),
            ];
            $attendance = EducatorAttendance::insert($attendanceData);
            //
        } else if ($editEducatorAttendanceDTO['attendance_type'] == 'Leave') {
            $attendanceData = [
                "attendance_type_id" => 3,
                "educator_id" =>  $editEducatorAttendanceDTO['educator_id'],
                "date" => $editEducatorAttendanceDTO['date'],
                "updated_by" => $editEducatorAttendanceDTO['updated_by'],
                'updated_at' => Carbon::now(),
            ];
            $attendance = EducatorAttendance::insert($attendanceData);
            //
        } else if ($editEducatorAttendanceDTO['attendance_type'] == 'Present') {
            $createEducatorAttendanceDataList = [];
            foreach ($editEducatorAttendanceDTO['in_out_list'] as $in_out_item) {
                if ($in_out_item['type'] == "In") {
                    $attendanceData = [];
                    $attendanceData = [
                        "time" => $in_out_item['time'],
                        "attendance_type_id" => 1,
                    ];
                    array_push($createEducatorAttendanceDataList, $attendanceData);
                }
                if ($in_out_item['type'] == "Out") {
                    $attendanceData = [];
                    $attendanceData = [
                        "time" => $in_out_item['time'],
                        "attendance_type_id" => 2,
                    ];
                    array_push($createEducatorAttendanceDataList, $attendanceData);
                }
            }
            $createEducatorAttendanceDataList = array_map(function ($item) use ($editEducatorAttendanceDTO) {
                return array_merge(
                    $item,
                    [
                        "educator_id" =>  $editEducatorAttendanceDTO['educator_id'],
                        "date" => $editEducatorAttendanceDTO['date'],
                        "updated_by" => $editEducatorAttendanceDTO['updated_by'],
                        'updated_at' => Carbon::now(),
                    ]
                );
            }, $createEducatorAttendanceDataList);
            $attendance = EducatorAttendance::insert($createEducatorAttendanceDataList);
        }

        return $attendance;
    }
}
