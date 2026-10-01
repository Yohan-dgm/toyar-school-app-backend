<?php

namespace Modules\SportManagement\Intents\StudentSport\RemoveStudentFromSport;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SportManagement\Models\StudentSportHistory;
use Modules\StudentManagement\Models\StudentSport;

class RemoveStudentFromSportAction
{
    use AsAction;

    public function handle(RemoveStudentFromSportUserDTO $userDTO, array $systemData): StudentSport
    {
        return DB::transaction(function () use ($userDTO, $systemData) {
            // Find the active enrollment
            $studentSport = StudentSport::where('student_id', $userDTO->student_id)
                ->where('sport_id', $userDTO->sport_id)
                ->where('is_active', true)
                ->first();

            if (! $studentSport) {
                throw new \Exception('Active enrollment not found for this student in the specified sport');
            }

            // Update the enrollment to inactive
            $studentSport->update([
                'is_active' => false,
                'left_date' => $userDTO->left_date ?? now()->format('Y-m-d'),
                'updated_by' => $systemData['updated_by'],
            ]);

            // Record history
            $this->recordHistory(
                $studentSport,
                StudentSportHistory::ACTION_LEFT,
                $userDTO->reason,
                $userDTO->notes,
                $systemData['updated_by']
            );

            return $studentSport->load(['student', 'sport', 'coach']);
        });
    }

    private function recordHistory(
        StudentSport $studentSport,
        string $actionType,
        ?string $reason,
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
            'reason' => $reason,
            'notes' => $notes,
            'created_by' => $updatedBy,
            'created_at' => now(),
        ]);
    }
}
