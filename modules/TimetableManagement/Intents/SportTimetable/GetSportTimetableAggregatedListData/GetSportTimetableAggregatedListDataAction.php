<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\GetSportTimetableAggregatedListData;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\SportTimetable;

class GetSportTimetableAggregatedListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getSportTimetableAggregatedListDataUserDTO = GetSportTimetableAggregatedListDataUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];

        // System Data Validation
        $getSportTimetableAggregatedListDataSystemDTO = GetSportTimetableAggregatedListDataSystemDTO::validate($system_data);

        // Get Aggregated Data
        $query = SportTimetable::select([
            'sport_id',
            'coach_id',
            'season',
            'academic_year',
            'skill_level',
            'day_of_week',
            DB::raw('COUNT(*) as total_sessions'),
            DB::raw('COUNT(DISTINCT grade_level_class_id) as total_classes'),
            DB::raw('SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active_sessions'),
            DB::raw('AVG(max_participants) as avg_max_participants'),
        ])
            ->with(['sport', 'coach']);

        // Apply filters
        if (isset($getSportTimetableAggregatedListDataUserDTO['sport_id'])) {
            $query->where('sport_id', $getSportTimetableAggregatedListDataUserDTO['sport_id']);
        }

        if (isset($getSportTimetableAggregatedListDataUserDTO['coach_id'])) {
            $query->where('coach_id', $getSportTimetableAggregatedListDataUserDTO['coach_id']);
        }

        if (isset($getSportTimetableAggregatedListDataUserDTO['season'])) {
            $query->where('season', $getSportTimetableAggregatedListDataUserDTO['season']);
        }

        if (isset($getSportTimetableAggregatedListDataUserDTO['academic_year'])) {
            $query->where('academic_year', $getSportTimetableAggregatedListDataUserDTO['academic_year']);
        }

        if (isset($getSportTimetableAggregatedListDataUserDTO['skill_level'])) {
            $query->where('skill_level', $getSportTimetableAggregatedListDataUserDTO['skill_level']);
        }

        if (isset($getSportTimetableAggregatedListDataUserDTO['day_of_week'])) {
            $query->where('day_of_week', $getSportTimetableAggregatedListDataUserDTO['day_of_week']);
        }

        // Group by
        $query->groupBy(['sport_id', 'coach_id', 'season', 'academic_year', 'skill_level', 'day_of_week']);

        // Order by
        $query->orderBy('sport_id', 'asc')
            ->orderBy('day_of_week', 'asc');

        // Pagination
        $perPage = $getSportTimetableAggregatedListDataUserDTO['per_page'] ?? 15;
        $aggregatedData = $query->paginate($perPage);

        return $aggregatedData;
    }
}
