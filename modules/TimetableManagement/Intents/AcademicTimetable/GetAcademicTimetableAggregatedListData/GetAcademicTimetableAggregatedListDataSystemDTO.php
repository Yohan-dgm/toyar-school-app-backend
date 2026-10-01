<?php

namespace Modules\TimetableManagement\Intents\AcademicTimetable\GetAcademicTimetableAggregatedListData;

class GetAcademicTimetableAggregatedListDataSystemDTO
{
    public static function validate($payloadArray)
    {
        // For read operations, no system data validation is typically required
        // This follows the established architecture pattern
        return [];
    }
}
