<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\GetAcademicTimetableListData;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\AcademicTimetable;

class GetAcademicTimetableListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getAcademicTimetableListDataUserDTO = GetAcademicTimetableListDataUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];

        // System Data Validation
        $getAcademicTimetableListDataSystemDTO = GetAcademicTimetableListDataSystemDTO::validate($system_data);

        // Get Data
        $query = AcademicTimetable::with(['grade_level_class', 'subject', 'educator', 'user']);

        // Apply filters
        if (isset($getAcademicTimetableListDataUserDTO['grade_level_class_id'])) {
            $query->where('grade_level_class_id', $getAcademicTimetableListDataUserDTO['grade_level_class_id']);
        }

        if (isset($getAcademicTimetableListDataUserDTO['subject_id'])) {
            $query->where('subject_id', $getAcademicTimetableListDataUserDTO['subject_id']);
        }

        if (isset($getAcademicTimetableListDataUserDTO['educator_id'])) {
            $query->where('educator_id', $getAcademicTimetableListDataUserDTO['educator_id']);
        }

        if (isset($getAcademicTimetableListDataUserDTO['day_of_week'])) {
            $query->where('day_of_week', $getAcademicTimetableListDataUserDTO['day_of_week']);
        }

        if (isset($getAcademicTimetableListDataUserDTO['semester'])) {
            $query->where('semester', $getAcademicTimetableListDataUserDTO['semester']);
        }

        if (isset($getAcademicTimetableListDataUserDTO['academic_year'])) {
            $query->where('academic_year', $getAcademicTimetableListDataUserDTO['academic_year']);
        }

        if (isset($getAcademicTimetableListDataUserDTO['is_active'])) {
            $query->where('is_active', $getAcademicTimetableListDataUserDTO['is_active']);
        }

        if (isset($getAcademicTimetableListDataUserDTO['building'])) {
            $query->where('building', 'like', '%'.$getAcademicTimetableListDataUserDTO['building'].'%');
        }

        if (isset($getAcademicTimetableListDataUserDTO['room_number'])) {
            $query->where('room_number', 'like', '%'.$getAcademicTimetableListDataUserDTO['room_number'].'%');
        }

        // Order by
        $query->orderBy('day_of_week', 'asc')
            ->orderBy('start_time', 'asc');

        // Pagination
        $perPage = $getAcademicTimetableListDataUserDTO['per_page'] ?? 15;
        $academicTimetables = $query->paginate($perPage);

        return $academicTimetables;
    }
}
