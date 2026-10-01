<?php

namespace Modules\AcademicStaffManagement\Intents\ClassTeacher\DeleteClassTeacher;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\AcademicStaffManagement\Models\ClassTeacher;

class DeleteClassTeacherAction
{
    use AsAction;

    public function handle($id)
    {
        // Find the class teacher assignment
        $classTeacher = ClassTeacher::findOrFail($id);

        // Delete the assignment
        $classTeacher->delete();

        return true;
    }
}
