<?php

namespace Modules\SportManagement\Intents\StudentSport\GetStudentsBySport;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\StudentManagement\Models\StudentSport;

class GetStudentsBySportIntent
{
    use AsAction;

    public function handle(Request $request, int $sport_id)
    {
        $includeInactive = $request->boolean('include_inactive', false);

        $query = StudentSport::with(['student', 'coach'])
            ->where('sport_id', $sport_id);

        if (! $includeInactive) {
            $query->where('is_active', true);
        }

        return $query->get()->map(function ($enrollment) {
            return [
                'enrollment_id' => $enrollment->id,
                'student' => [
                    'id' => $enrollment->student->id,
                    'name' => $enrollment->student->name ?? 'N/A',
                    'student_number' => $enrollment->student->student_number ?? 'N/A',
                ],
                'coach' => $enrollment->coach ? [
                    'id' => $enrollment->coach->id,
                    'name' => $enrollment->coach->name ?? 'N/A',
                ] : null,
                'enrolled_date' => $enrollment->enrolled_date?->format('Y-m-d'),
                'left_date' => $enrollment->left_date?->format('Y-m-d'),
                'is_active' => $enrollment->is_active,
                'enrollment_duration_days' => $enrollment->enrolled_date && $enrollment->is_active ?
                    now()->diffInDays($enrollment->enrolled_date) : null,
                'created_at' => $enrollment->created_at?->format('Y-m-d H:i:s'),
            ];
        });
    }

    public function asController(Request $request, int $sport_id): JsonResponse
    {
        try {
            $result = $this->handle($request, $sport_id);

            return response()->json([
                'status' => 'successful',
                'message' => 'Students retrieved successfully',
                'data' => $result,
                'metadata' => [
                    'sport_id' => $sport_id,
                    'total_students' => $result->count(),
                    'include_inactive' => $request->boolean('include_inactive', false),
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => 'An unexpected error occurred',
                'data' => null,
                'metadata' => null,
            ], 500);
        }
    }
}
