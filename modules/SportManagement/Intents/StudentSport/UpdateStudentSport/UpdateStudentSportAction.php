<?php

namespace Modules\SportManagement\Intents\StudentSport\UpdateStudentSport;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SportManagement\Models\StudentSportHistory;
use Modules\StudentManagement\Models\StudentSport;

class UpdateStudentSportAction
{
    use AsAction;

    public function handle(UpdateStudentSportUserDTO $userDTO, array $systemData): StudentSport
    {
        return DB::transaction(function () use ($userDTO, $systemData) {
            // Find the enrollment
            $studentSport = StudentSport::where('student_id', $userDTO->student_id)
                ->where('sport_id', $userDTO->sport_id)
                ->first();

            if (! $studentSport) {
                throw new \Exception('Enrollment not found for this student in the specified sport');
            }

            // Store original values for comparison
            $originalCoachId = $studentSport->coach_id;
            $originalIsActive = $studentSport->is_active;

            // Prepare update data - only include non-null values
            $updateData = array_filter([
                'coach_id' => $userDTO->coach_id,
                'enrolled_date' => $userDTO->enrolled_date,
                'is_active' => $userDTO->is_active,
                'updated_by' => $systemData['updated_by'],
            ], function ($value) {
                return $value !== null;
            });

            // Update the enrollment
            $studentSport->update($updateData);

            // Record history for coach changes
            if ($userDTO->coach_id !== null && $originalCoachId !== $userDTO->coach_id) {
                $this->recordHistory(
                    $studentSport,
                    StudentSportHistory::ACTION_COACH_CHANGED,
                    $userDTO->notes ?? "Coach changed from ID {$originalCoachId} to {$userDTO->coach_id}",
                    $systemData['updated_by']
                );
            }

            // Record history for status changes (reactivation)
            if ($userDTO->is_active !== null && ! $originalIsActive && $userDTO->is_active) {
                $this->recordHistory(
                    $studentSport,
                    StudentSportHistory::ACTION_REACTIVATED,
                    $userDTO->notes ?? 'Enrollment reactivated',
                    $systemData['updated_by']
                );
            }

            return $studentSport->fresh(['student', 'sport', 'coach']);
        });
    }

    private function recordHistory(
        StudentSport $studentSport,
        string $actionType,
        ?string $notes,
        int $updatedBy
    ): void {
        StudentSportHistory::create([
            'student_sport_id' => $studentSport->id,
            'student_id' => $studentSport->student_id,
            'sport_id' => $studentSport->sport_id,
            'coach_id' => $studentSport->coach_id,
            'action_type' => $actionType,
            'enrolled_date' => $studentSport->enrolled_date,
            'left_date' => $studentSport->left_date,
            'notes' => $notes,
            'created_by' => $updatedBy,
            'created_at' => now(),
        ]);
    }
}
