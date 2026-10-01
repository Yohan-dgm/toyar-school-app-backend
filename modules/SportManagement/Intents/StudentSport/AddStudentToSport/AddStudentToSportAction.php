<?php

namespace Modules\SportManagement\Intents\StudentSport\AddStudentToSport;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\SportManagement\Models\StudentSportHistory;
use Modules\StudentManagement\Models\StudentSport;

class AddStudentToSportAction
{
    use AsAction;

    public function handle(AddStudentToSportUserDTO $userDTO, array $systemData): StudentSport
    {
        return DB::transaction(function () use ($userDTO, $systemData) {
            // Check if student is already enrolled in this sport
            $existingEnrollment = StudentSport::where('student_id', $userDTO->student_id)
                ->where('sport_id', $userDTO->sport_id)
                ->first();

            if ($existingEnrollment && $existingEnrollment->is_active) {
                throw new \Exception('Student is already enrolled in this sport');
            }

            // If there's an inactive enrollment, reactivate it
            if ($existingEnrollment && ! $existingEnrollment->is_active) {
                $existingEnrollment->update([
                    'is_active' => true,
                    'coach_id' => $userDTO->coach_id,
                    'enrolled_date' => $userDTO->enrolled_date ?? now()->format('Y-m-d'),
                    'left_date' => null,
                    'updated_by' => $systemData['created_by'],
                ]);

                // Record history
                $this->recordHistory($existingEnrollment, StudentSportHistory::ACTION_REACTIVATED, $userDTO->notes, $systemData['created_by']);

                return $existingEnrollment->fresh();
            }

            // Create system DTO
            $systemDTO = new AddStudentToSportSystemDTO(
                created_by: $systemData['created_by'],
                updated_by: $systemData['created_by'],
                created_at: now()->toDateTimeString(),
                updated_at: now()->toDateTimeString()
            );

            // Create final DTO
            $finalDTO = AddStudentToSportDTO::from($userDTO, $systemDTO);

            // Create new enrollment
            $studentSport = StudentSport::create($finalDTO->toArray());

            // Record history
            $this->recordHistory($studentSport, StudentSportHistory::ACTION_ENROLLED, $userDTO->notes, $systemData['created_by']);

            return $studentSport->load(['student', 'sport', 'coach']);
        });
    }

    private function recordHistory(StudentSport $studentSport, string $actionType, ?string $notes, int $createdBy): void
    {
        StudentSportHistory::create([
            'student_sport_id' => $studentSport->id,
            'student_id' => $studentSport->student_id,
            'sport_id' => $studentSport->sport_id,
            'coach_id' => $studentSport->coach_id,
            'action_type' => $actionType,
            'enrolled_date' => $studentSport->enrolled_date,
            'left_date' => $studentSport->left_date,
            'notes' => $notes,
            'created_by' => $createdBy,
            'created_at' => now(),
        ]);
    }
}
