<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\GetSportTimetableListData;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\TimetableManagement\Models\SportTimetable;

class GetSportTimetableListDataAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $getSportTimetableListDataUserDTO = GetSportTimetableListDataUserDTO::validate($payloadArray);

        // Data Prep

        // System Data Prep
        $system_data = [];

        // System Data Validation
        $getSportTimetableListDataSystemDTO = GetSportTimetableListDataSystemDTO::validate($system_data);

        // Get Data
        $query = SportTimetable::with(['sport', 'grade_level_class', 'coach', 'user']);

        // Apply filters
        if (isset($getSportTimetableListDataUserDTO['sport_id'])) {
            $query->where('sport_id', $getSportTimetableListDataUserDTO['sport_id']);
        }

        if (isset($getSportTimetableListDataUserDTO['grade_level_class_id'])) {
            $query->where('grade_level_class_id', $getSportTimetableListDataUserDTO['grade_level_class_id']);
        }

        if (isset($getSportTimetableListDataUserDTO['coach_id'])) {
            $query->where('coach_id', $getSportTimetableListDataUserDTO['coach_id']);
        }

        if (isset($getSportTimetableListDataUserDTO['day_of_week'])) {
            $query->where('day_of_week', $getSportTimetableListDataUserDTO['day_of_week']);
        }

        if (isset($getSportTimetableListDataUserDTO['season'])) {
            $query->where('season', $getSportTimetableListDataUserDTO['season']);
        }

        if (isset($getSportTimetableListDataUserDTO['academic_year'])) {
            $query->where('academic_year', $getSportTimetableListDataUserDTO['academic_year']);
        }

        if (isset($getSportTimetableListDataUserDTO['is_active'])) {
            $query->where('is_active', $getSportTimetableListDataUserDTO['is_active']);
        }

        if (isset($getSportTimetableListDataUserDTO['venue'])) {
            $query->where('venue', 'like', '%'.$getSportTimetableListDataUserDTO['venue'].'%');
        }

        if (isset($getSportTimetableListDataUserDTO['facility'])) {
            $query->where('facility', 'like', '%'.$getSportTimetableListDataUserDTO['facility'].'%');
        }

        if (isset($getSportTimetableListDataUserDTO['skill_level'])) {
            $query->where('skill_level', $getSportTimetableListDataUserDTO['skill_level']);
        }

        if (isset($getSportTimetableListDataUserDTO['age_group'])) {
            $query->where('age_group', 'like', '%'.$getSportTimetableListDataUserDTO['age_group'].'%');
        }

        if (isset($getSportTimetableListDataUserDTO['team_id'])) {
            $query->where('team_id', $getSportTimetableListDataUserDTO['team_id']);
        }

        // Order by
        $query->where('is_active', true);
        $query->orderBy('day_of_week', 'asc')
            ->orderBy('start_time', 'asc');

        // Pagination
        $perPage = $getSportTimetableListDataUserDTO['per_page'] ?? 15;
        $sportTimetables = $query->paginate($perPage);

        return $sportTimetables;
    }
}
