<?php

namespace Modules\AcademicStaffManagement\Intents\ClassTeacher\GetClassTeacherList;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AcademicStaffManagement\Models\ClassTeacher;

class GetClassTeacherListAction
{
    use AsAction;

    public function handle($filters = [])
    {
        $query = ClassTeacher::with([
            'user',
            'grade_level_class.grade_level',
            'grade_level_class.class_section',
        ]);

        // Apply filters
        if (isset($filters['user_id'])) {
            $query->where('user_id', $filters['user_id']);
        }

        if (isset($filters['grade_level_class_id'])) {
            $query->where('grade_level_class_id', $filters['grade_level_class_id']);
        }

        if (isset($filters['academic_year'])) {
            $query->where('academic_year', $filters['academic_year']);
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        if (isset($filters['current']) && $filters['current'] === true) {
            $query->current();
        }

        // Order by most recent first
        $query->orderBy('created_at', 'desc');

        return $query->get();
    }
}
