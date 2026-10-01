<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\GetAcademicTimetableAggregatedListData;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\AcademicTimetable;

class GetAcademicTimetableAggregatedListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getAcademicTimetableAggregatedListDataUserDTO = GetAcademicTimetableAggregatedListDataUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];

        // System Data Validation
        $getAcademicTimetableAggregatedListDataSystemDTO = GetAcademicTimetableAggregatedListDataSystemDTO::validate($system_data);

        // Get Aggregated Data
        $query = AcademicTimetable::select([
            'grade_level_class_id',
            'subject_id',
            'educator_id',
            'semester',
            'academic_year',
            'day_of_week',
            DB::raw('COUNT(*) as total_classes'),
            DB::raw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_classes'),
            DB::raw('COUNT(DISTINCT room_number) as total_rooms'),
            DB::raw('COUNT(DISTINCT building) as total_buildings'),
        ])
            ->with(['grade_level_class', 'subject', 'educator']);

        // Apply filters
        if (isset($getAcademicTimetableAggregatedListDataUserDTO['grade_level_class_id'])) {
            $query->where('grade_level_class_id', $getAcademicTimetableAggregatedListDataUserDTO['grade_level_class_id']);
        }

        if (isset($getAcademicTimetableAggregatedListDataUserDTO['subject_id'])) {
            $query->where('subject_id', $getAcademicTimetableAggregatedListDataUserDTO['subject_id']);
        }

        if (isset($getAcademicTimetableAggregatedListDataUserDTO['educator_id'])) {
            $query->where('educator_id', $getAcademicTimetableAggregatedListDataUserDTO['educator_id']);
        }

        if (isset($getAcademicTimetableAggregatedListDataUserDTO['semester'])) {
            $query->where('semester', $getAcademicTimetableAggregatedListDataUserDTO['semester']);
        }

        if (isset($getAcademicTimetableAggregatedListDataUserDTO['academic_year'])) {
            $query->where('academic_year', $getAcademicTimetableAggregatedListDataUserDTO['academic_year']);
        }

        if (isset($getAcademicTimetableAggregatedListDataUserDTO['day_of_week'])) {
            $query->where('day_of_week', $getAcademicTimetableAggregatedListDataUserDTO['day_of_week']);
        }

        // Group by
        $query->groupBy(['grade_level_class_id', 'subject_id', 'educator_id', 'semester', 'academic_year', 'day_of_week']);

        // Order by
        $query->orderBy('grade_level_class_id', 'asc')
            ->orderBy('day_of_week', 'asc');

        // Pagination
        $perPage = $getAcademicTimetableAggregatedListDataUserDTO['per_page'] ?? 15;
        $aggregatedData = $query->paginate($perPage);

        return $aggregatedData;
    }
}
