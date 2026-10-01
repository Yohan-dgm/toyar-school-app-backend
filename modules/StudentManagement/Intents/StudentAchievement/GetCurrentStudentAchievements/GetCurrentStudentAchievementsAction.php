<?php

namespace Modules\StudentManagement\Intents\StudentAchievement\GetCurrentStudentAchievements;

use Carbon\Carbon;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\Student;
use Modules\StudentManagement\Models\StudentAchievement;

class GetCurrentStudentAchievementsAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        $getCurrentStudentAchievementsUserDTO = GetCurrentStudentAchievementsUserDTO::validate($payloadArray);

        $studentId = $getCurrentStudentAchievementsUserDTO['student_id'];
        $currentDate = Carbon::today()->format('Y-m-d');

        // First, verify the student exists
        $student = Student::select('id', 'full_name', 'full_name_with_title', 'admission_number')
            ->find($studentId);

        if (! $student) {
            throw new \Exception('Student not found');
        }

        // Get achievements where current date is between start_date and end_date
        $currentAchievements = StudentAchievement::where('student_id', $studentId)
            ->where('is_active', true)
            ->where('start_date', '<=', $currentDate)
            ->where('end_date', '>=', $currentDate)
            ->select(
                'id',
                'student_id',
                'achievement_type',
                'title',
                'description',
                'start_date',
                'end_date',
                'is_active',
                'created_at',
                'updated_at'
            )
            ->orderBy('start_date', 'desc')
            ->get();

        // Format achievements data
        $achievementsData = $currentAchievements->map(function ($achievement) {
            return [
                'id' => $achievement->id,
                'achievement_type' => $achievement->achievement_type,
                'title' => $achievement->title,
                'description' => $achievement->description,
                'start_date' => $achievement->start_date?->format('Y-m-d'),
                'end_date' => $achievement->end_date?->format('Y-m-d'),
                'is_active' => $achievement->is_active,
                'duration_days' => $achievement->start_date && $achievement->end_date
                    ? $achievement->start_date->diffInDays($achievement->end_date) + 1
                    : null,
                'created_at' => $achievement->created_at?->toISOString(),
                'updated_at' => $achievement->updated_at?->toISOString(),
            ];
        })->toArray();

        return [
            'student_id' => $student->id,
            'student_info' => [
                'full_name' => $student->full_name,
                'full_name_with_title' => $student->full_name_with_title,
                'admission_number' => $student->admission_number,
            ],
            'current_achievements' => $achievementsData,
            'total_achievements' => count($achievementsData),
            'current_date' => $currentDate,
        ];
    }
}
