<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Modules\EducatorFeedbackManagement\Models\EducatorFeedback;
use Modules\EducatorFeedbackManagement\Models\FeedbackCategory;
use Modules\StudentManagement\Models\Grade;
use Modules\StudentManagement\Models\Student;

class EducatorFeedbackService
{
    public function getGradesList()
    {
        // This assumes you have a Grade model in the StudentManagement module
        $grades = Grade::where('active', true)
            ->withCount('students')
            ->orderBy('level')
            ->get()
            ->map(function ($grade) {
                return [
                    'id' => $grade->id,
                    'name' => $grade->name,
                    'students_count' => $grade->students_count,
                    'active' => $grade->active,
                ];
            });

        return response()->json([
            'status' => 'successful',
            'message' => 'Grades retrieved successfully',
            'data' => ['grades' => $grades],
        ]);
    }

    public function getStudentsByGrade($grade, $search = null)
    {
        $query = Student::where('grade_id', $grade)
            ->where('active', true);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('admission_number', 'like', "%{$search}%");
            });
        }

        $students = $query->orderBy('name')->get();

        return response()->json([
            'status' => 'successful',
            'message' => 'Students retrieved successfully',
            'data' => [
                'students' => $students,
                'total_count' => $students->count(),
            ],
        ]);
    }

    public function getCategoriesWithQuestions()
    {
        $categories = FeedbackCategory::with(['questions.options', 'subcategories'])
            ->where('active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'status' => 'successful',
            'message' => 'Categories and questions retrieved successfully',
            'data' => ['categories' => $categories],
        ]);
    }

    public function listFeedbacks($data)
    {
        $query = EducatorFeedback::with(['student', 'educator', 'category', 'subcategories']);

        if (isset($data['search_phrase'])) {
            $query->where('description', 'like', '%'.$data['search_phrase'].'%');
        }

        if (isset($data['grade_id'])) {
            $query->whereHas('student', function ($q) use ($data) {
                $q->where('grade_id', $data['grade_id']);
            });
        }

        if (isset($data['student_id'])) {
            $query->where('student_id', $data['student_id']);
        }

        if (isset($data['category_id'])) {
            $query->where('main_category', $data['category_id']);
        }

        if (isset($data['rating'])) {
            $query->where('rating', $data['rating']);
        }

        if (isset($data['educator_id'])) {
            $query->where('educator_id', $data['educator_id']);
        }

        if (isset($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (isset($data['date_from'])) {
            $query->whereDate('created_at', '>=', $data['date_from']);
        }

        if (isset($data['date_to'])) {
            $query->whereDate('created_at', '<=', $data['date_to']);
        }

        $feedbacks = $query->paginate($data['page_size'] ?? 10, ['*'], 'page', $data['page'] ?? 1);

        return response()->json([
            'status' => 'successful',
            'message' => 'Feedbacks retrieved successfully',
            'data' => $feedbacks,
        ]);
    }

    public function createFeedback($data)
    {
        DB::beginTransaction();
        try {
            // Calculate rating from questionnaire answers
            $rating = $this->calculateRatingFromAnswers($data['questionnaire_answers'] ?? []);

            $feedback = EducatorFeedback::create([
                'school_id' => auth()->user()->school_id,
                'student_id' => $data['student_id'],
                'educator_id' => auth()->id(),
                'main_category' => $data['main_category'],
                'subcategories' => $data['subcategories'] ?? [],
                'description' => $data['description'],
                'rating' => $rating,
                'questionnaire_answers' => $data['questionnaire_answers'] ?? [],
                'status' => 'pending',
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return response()->json([
                'status' => 'successful',
                'message' => 'Feedback submitted successfully',
                'data' => ['feedback' => $feedback],
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit feedback: '.$e->getMessage(),
            ], 500);
        }
    }

    private function calculateRatingFromAnswers($answers)
    {
        if (empty($answers)) {
            return 0;
        }

        $totalMarks = 0;
        $validAnswersCount = 0;

        foreach ($answers as $answer) {
            if (isset($answer['marks']) && $answer['marks'] > 0) {
                $totalMarks += $answer['marks'];
                $validAnswersCount++;
            }
        }

        return $validAnswersCount > 0 ? round($totalMarks / $validAnswersCount, 2) : 0;
    }

    public function updateFeedback($data)
    {
        $feedback = EducatorFeedback::find($data['feedback_id']);

        if (! $feedback) {
            return response()->json([
                'status' => 'error',
                'message' => 'Feedback not found',
            ], 404);
        }

        $feedback->update($data);

        if (isset($data['subcategories'])) {
            $feedback->subcategories()->sync($data['subcategories']);
        }

        return response()->json([
            'status' => 'successful',
            'message' => 'Feedback updated successfully',
            'data' => [
                'feedback' => $feedback->load('subcategories'),
            ],
        ]);
    }

    public function deleteFeedback($feedbackId)
    {
        $feedback = EducatorFeedback::find($feedbackId);

        if (! $feedback) {
            return response()->json([
                'status' => 'error',
                'message' => 'Feedback not found',
            ], 404);
        }

        $feedback->delete();

        return response()->json([
            'status' => 'successful',
            'message' => 'Feedback deleted successfully',
            'data' => [
                'deleted_feedback_id' => $feedbackId,
            ],
        ]);
    }

    public function getMetadata($data)
    {
        // This is a placeholder implementation. You would query your database
        // for actual analytics data based on the provided filters.
        // For example, using the feedback_analytics table if it's implemented for caching.

        $totalFeedbacks = EducatorFeedback::count();
        $pendingFeedbacks = EducatorFeedback::where('status', 'pending')->count();
        $approvedFeedbacks = EducatorFeedback::where('status', 'approved')->count();
        $averageRating = EducatorFeedback::avg('rating');

        return response()->json([
            'status' => 'successful',
            'message' => 'Metadata retrieved successfully',
            'data' => [
                'statistics' => [
                    'total_feedbacks' => $totalFeedbacks,
                    'pending_approval' => $pendingFeedbacks,
                    'approved' => $approvedFeedbacks,
                    'rejected' => 0, // Placeholder
                    'average_rating' => round($averageRating, 2),
                    'rating_distribution' => [], // Placeholder
                ],
                'category_breakdown' => [], // Placeholder
                'monthly_trends' => [], // Placeholder
                'top_educators' => [], // Placeholder
            ],
        ]);
    }
}
