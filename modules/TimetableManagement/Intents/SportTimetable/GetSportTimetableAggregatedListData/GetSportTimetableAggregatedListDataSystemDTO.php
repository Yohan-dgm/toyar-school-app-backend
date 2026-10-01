<?php

namespace Modules\TimetableManagement\Intents\SportTimetable\GetSportTimetableAggregatedListData;

class GetSportTimetableAggregatedListDataSystemDTO
{
    public static function validate($payloadArray)
    {
        // For read operations, no system data validation is typically required
        // This follows the established architecture pattern
        return [];
    }
}
