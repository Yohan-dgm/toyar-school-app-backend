<?php

namespace Modules\AttendanceManagement\Intents\EducatorAttendance\UpdateEducatorAttendance;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AttendanceManagement\Models\EducatorAttendance;

class UpdateEducatorAttendanceAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateEducatorAttendanceUserDTO = UpdateEducatorAttendanceUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];
        $system_data['updated_by'] = $actionData['updated_by'];

        // System Data Validation
        $updateEducatorAttendanceSystemDTO = UpdateEducatorAttendanceSystemDTO::validate($system_data);
        // Final Data Validation
        $updateEducatorAttendanceDTO = UpdateEducatorAttendanceDTO::validate(array_merge($updateEducatorAttendanceUserDTO, $updateEducatorAttendanceSystemDTO));

        // Delete In Database
        // find all records for educator_id, date
        // delete
        EducatorAttendance::where('educator_id', $updateEducatorAttendanceUserDTO['educator_id'])
            ->where('date', $updateEducatorAttendanceUserDTO['date'])->delete();

        // Create In Database
        // if attendace_type == Absent
        // create 1 record - attendace_type_id= absent id, educator, date
        if ($updateEducatorAttendanceDTO['attendance_type'] == 'Absent') {
            $attendanceData = [
                'attendance_type_id' => 4,
                'educator_id' => $updateEducatorAttendanceUserDTO['educator_id'],
                'date' => $updateEducatorAttendanceUserDTO['date'],
                'created_by' => $updateEducatorAttendanceDTO['updated_by'],
                'created_at' => Carbon::now(),
                'updated_by' => $updateEducatorAttendanceDTO['updated_by'],
                'updated_at' => Carbon::now(),
            ];
            $attendanceData['notes'] = array_key_exists('notes', $updateEducatorAttendanceUserDTO) && ! is_null($updateEducatorAttendanceUserDTO['notes']) ? $updateEducatorAttendanceUserDTO['notes'] : null;
            $attendance = EducatorAttendance::insert($attendanceData);
            //
        } elseif ($updateEducatorAttendanceDTO['attendance_type'] == 'Leave') {
            // if attendace_type == Leave
            $attendanceData = [
                'attendance_type_id' => 3,
                'educator_id' => $updateEducatorAttendanceUserDTO['educator_id'],
                'date' => $updateEducatorAttendanceUserDTO['date'],
                'created_by' => $updateEducatorAttendanceDTO['updated_by'],
                'created_at' => Carbon::now(),
                'updated_by' => $updateEducatorAttendanceDTO['updated_by'],
                'updated_at' => Carbon::now(),
            ];
            $attendanceData['notes'] = array_key_exists('notes', $updateEducatorAttendanceUserDTO) && ! is_null($updateEducatorAttendanceUserDTO['notes']) ? $updateEducatorAttendanceUserDTO['notes'] : null;
            $attendance = EducatorAttendance::insert($attendanceData);
            //
        } elseif ($updateEducatorAttendanceDTO['attendance_type'] == 'Present') {
            // if attendace_type == Present
            // create 1 record for In - in_time
            // create 1 record for Out - out_time

            $createEducatorAttendanceDataList = [];
            $attendanceData = [
                'time' => $updateEducatorAttendanceDTO['in_time'],
                'attendance_type_id' => 1,
            ];
            $attendanceData['notes'] = array_key_exists('notes', $updateEducatorAttendanceUserDTO) && ! is_null($updateEducatorAttendanceUserDTO['notes']) ? $updateEducatorAttendanceUserDTO['notes'] : null;
            array_push($createEducatorAttendanceDataList, $attendanceData);

            $attendanceData = [
                'time' => $updateEducatorAttendanceDTO['out_time'],
                'attendance_type_id' => 2,
            ];
            $attendanceData['notes'] = array_key_exists('notes', $updateEducatorAttendanceUserDTO) && ! is_null($updateEducatorAttendanceUserDTO['notes']) ? $updateEducatorAttendanceUserDTO['notes'] : null;
            array_push($createEducatorAttendanceDataList, $attendanceData);

            $createEducatorAttendanceDataList = array_map(function ($item) use ($updateEducatorAttendanceDTO, $updateEducatorAttendanceUserDTO) {
                return array_merge(
                    $item,
                    [
                        'educator_id' => $updateEducatorAttendanceUserDTO['educator_id'],
                        'date' => $updateEducatorAttendanceUserDTO['date'],
                        'created_by' => $updateEducatorAttendanceDTO['updated_by'],
                        'created_at' => Carbon::now(),
                        'updated_by' => $updateEducatorAttendanceDTO['updated_by'],
                        'updated_at' => Carbon::now(),
                    ]
                );
            }, $createEducatorAttendanceDataList);

            $attendance = EducatorAttendance::insert($createEducatorAttendanceDataList);
        }

        return $attendance;
    }
}
