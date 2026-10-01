# Educator Feedback System - Backend Requirements

## Overview

This document outlines the complete backend requirements for the Educator Feedback system in the Toyar School App. The system allows educators to provide structured feedback on students using questionnaire-based assessments with automatic rating calculations.

## API Endpoints Required

### 1. Get Student List Data (Grades + Students Overview)

**Endpoint:** `GET /api/student-management/student/get-student-list-data`

**Purpose:** Get comprehensive student management data including grades, student counts, and other statistics

**Request:** No parameters required

**Response Format (Based on provided sample):**

---

### 3. Get Feedback Categories with Questions

**Endpoint:** `GET /api/educator-feedback/categories/with-questions`

**Purpose:** Get all feedback categories with their associated questions and answer options

**Request:** No parameters required

**Response Format:**

```json
{
    "status": "successful",
    "message": "Categories and questions retrieved successfully",
    "data": {
        "categories": [
            {
                "id": "academic_performance",
                "name": "Academic Performance",
                "description": "Assessment of student's academic abilities and achievements",
                "active": true,
                "sort_order": 1,
                "subcategories": [
                    "Mathematics",
                    "English Language",
                    "Science",
                    "History",
                    "Geography",
                    "Problem Solving",
                    "Critical Thinking",
                    "Research Skills"
                ],
                "questions": [
                    {
                        "id": "academic_1",
                        "category_id": "academic_performance",
                        "question": "How well does the student grasp new academic concepts?",
                        "answer_type": "scale",
                        "is_required": true,
                        "sort_order": 1,
                        "options": null
                    },
                    {
                        "id": "academic_2",
                        "category_id": "academic_performance",
                        "question": "Does the student demonstrate critical thinking in academic work?",
                        "answer_type": "predefined",
                        "is_required": true,
                        "sort_order": 2,
                        "options": [
                            {
                                "id": "opt_1",
                                "text": "Excellent critical analysis and reasoning",
                                "marks": 5,
                                "sort_order": 1
                            },
                            {
                                "id": "opt_2",
                                "text": "Good analytical thinking with minor gaps",
                                "marks": 4,
                                "sort_order": 2
                            },
                            {
                                "id": "opt_3",
                                "text": "Basic critical thinking skills",
                                "marks": 3,
                                "sort_order": 3
                            },
                            {
                                "id": "opt_4",
                                "text": "Limited analytical approach",
                                "marks": 2,
                                "sort_order": 4
                            },
                            {
                                "id": "opt_5",
                                "text": "Struggles with critical analysis",
                                "marks": 1,
                                "sort_order": 5
                            }
                        ]
                    },
                    {
                        "id": "academic_3",
                        "category_id": "academic_performance",
                        "question": "Describe the student's problem-solving approach and methodology:",
                        "answer_type": "custom",
                        "is_required": false,
                        "sort_order": 3,
                        "options": null
                    }
                ]
            },
            {
                "id": "behavioral_development",
                "name": "Behavioral Development",
                "description": "Assessment of student's behavior and conduct",
                "active": true,
                "sort_order": 2,
                "subcategories": [
                    "Classroom Behavior",
                    "Attendance & Punctuality",
                    "Following Instructions",
                    "Responsibility",
                    "Self-Discipline",
                    "Respect for Others",
                    "Honesty & Integrity"
                ],
                "questions": [
                    {
                        "id": "behavior_1",
                        "category_id": "behavioral_development",
                        "question": "How well does the student follow classroom rules and procedures?",
                        "answer_type": "scale",
                        "is_required": true,
                        "sort_order": 1,
                        "options": null
                    }
                ]
            },
            {
                "id": "social_skills",
                "name": "Social Skills",
                "description": "Assessment of student's interpersonal and social abilities",
                "active": true,
                "sort_order": 3,
                "subcategories": [
                    "Communication",
                    "Teamwork",
                    "Collaboration",
                    "Peer Interaction",
                    "Conflict Resolution",
                    "Empathy",
                    "Cultural Awareness"
                ],
                "questions": []
            },
            {
                "id": "creative_arts",
                "name": "Creative Arts",
                "description": "Assessment of student's creative and artistic abilities",
                "active": true,
                "sort_order": 4,
                "subcategories": [
                    "Visual Arts",
                    "Music",
                    "Drama & Theater",
                    "Creative Writing",
                    "Design Thinking",
                    "Innovation",
                    "Artistic Expression"
                ],
                "questions": []
            },
            {
                "id": "physical_development",
                "name": "Physical Development",
                "description": "Assessment of student's physical abilities and health awareness",
                "active": true,
                "sort_order": 5,
                "subcategories": [
                    "Sports & Athletics",
                    "Physical Fitness",
                    "Motor Skills",
                    "Health Awareness",
                    "Outdoor Activities",
                    "Coordination",
                    "Stamina & Endurance"
                ],
                "questions": []
            },
            {
                "id": "leadership_qualities",
                "name": "Leadership Qualities",
                "description": "Assessment of student's leadership potential and skills",
                "active": true,
                "sort_order": 6,
                "subcategories": [
                    "Initiative Taking",
                    "Decision Making",
                    "Mentoring Others",
                    "Public Speaking",
                    "Project Management",
                    "Delegation",
                    "Motivation & Inspiration"
                ],
                "questions": []
            }
        ]
    }
}
```

---

### 4. Get Educator Feedbacks (List with Filters)

**Endpoint:** `POST /api/educator-feedback/feedbacks/list`

**Purpose:** Get paginated list of educator feedbacks with filtering options

**Request Body:**

```json
{
    "page": 1,
    "page_size": 10,
    "search_phrase": " ",
    "grade_id": 1,
    "student_id": 5,
    "category_id": 2,
    "rating": "5",
    "educator_id": 21,
    "status": 1,
    "date_from": "2024-01-01",
    "date_to": "2024-12-31"
}
```

**Response Format:**

```json
{
    "status": "successful",
    "message": "Feedbacks retrieved successfully",
    "data": {
        "feedbacks": [
            {
                "id": "feedback_001",
                "student": {
                    "id": "std_001",
                    "name": "John Smith",
                    "admission_number": "ADM001",
                    "grade": "Grade 10",
                    "profile_image": "https://example.com/profiles/std_001.jpg"
                },
                "educator": {
                    "id": "edu_001",
                    "name": "Ms. Sarah Johnson",
                    "subject": "Mathematics",
                    "profile_image": "https://example.com/profiles/edu_001.jpg"
                },
                "main_category": "Academic Performance",
                "subcategories": ["Mathematics", "Problem Solving"],
                "description": "Excellent performance in mathematics and shows great problem-solving skills. Very attentive in class and helps other students.",
                "rating": 4.8,
                "questionnaire_answers": {
                    "academic_1": {
                        "question": "How well does the student grasp new academic concepts?",
                        "answer": 5,
                        "marks": 5,
                        "answer_type": "scale"
                    },
                    "academic_2": {
                        "question": "Does the student demonstrate critical thinking in academic work?",
                        "answer": "Excellent critical analysis and reasoning",
                        "marks": 5,
                        "answer_type": "predefined"
                    },
                    "academic_3": {
                        "question": "Describe the student's problem-solving approach:",
                        "answer": "Uses systematic approach, breaks down complex problems into manageable steps.",
                        "marks": 0,
                        "answer_type": "custom"
                    }
                },
                "status": "approved",
                "created_at": "2025-01-20T10:30:00Z",
                "updated_at": "2025-01-20T10:30:00Z",
                "created_by": "edu_001",
                "approved_by": "principal_001",
                "approved_at": "2025-01-20T15:45:00Z",
                "revision_instructions": null
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 10,
            "total": 150,
            "last_page": 15,
            "has_more": true
        },
        "summary": {
            "total_feedbacks": 150,
            "pending_feedbacks": 12,
            "approved_feedbacks": 138,
            "average_rating": 4.2
        }
    }
}
```

---

### 5. Submit New Educator Feedback

**Endpoint:** `POST /api/educator-feedback/feedbacks/create`

**Purpose:** Submit a new educator feedback

**Request Body:**

```json
{
    "student_id": "std_001",
    "grade": "Grade 10",
    "main_category": "Academic Performance",
    "subcategories": ["Mathematics", "Problem Solving"],
    "description": "Excellent performance in mathematics and shows great problem-solving skills.",
    "rating": 4.8,
    "questionnaire_answers": {
        "academic_1": {
            "answer": 5,
            "marks": 5
        },
        "academic_2": {
            "answer": "Excellent critical analysis and reasoning",
            "marks": 5
        },
        "academic_3": {
            "answer": "Uses systematic approach to solve problems.",
            "marks": 0
        }
    }
}
```

**Response Format:**

```json
{
    "status": "successful",
    "message": "Feedback submitted successfully",
    "data": {
        "feedback": {
            "id": "feedback_new_001",
            "student_id": "std_001",
            "educator_id": "edu_001",
            "main_category": "Academic Performance",
            "subcategories": ["Mathematics", "Problem Solving"],
            "description": "Excellent performance in mathematics and shows great problem-solving skills.",
            "rating": 4.8,
            "questionnaire_answers": {},
            "status": "pending",
            "created_at": "2025-01-22T10:30:00Z",
            "updated_at": "2025-01-22T10:30:00Z"
        }
    }
}
```

---

### 6. Update Educator Feedback

**Endpoint:** `POST /api/educator-feedback/feedbacks/update`

**Purpose:** Update an existing educator feedback

**Request Body:**

```json
{
    "feedback_id": "feedback_001",
    "description": "Updated description",
    "subcategories": ["Mathematics", "Critical Thinking"],
    "rating": 4.9,
    "questionnaire_answers": {}
}
```

**Response Format:**

```json
{
    "status": "successful",
    "message": "Feedback updated successfully",
    "data": {
        "feedback": {
            "id": "feedback_001",
            "updated_at": "2025-01-22T11:30:00Z"
        }
    }
}
```

---

### 7. Delete Educator Feedback

**Endpoint:** `POST /api/educator-feedback/feedbacks/delete`

**Purpose:** Delete an educator feedback

**Request Body:**

```json
{
    "feedback_id": "feedback_001"
}
```

**Response Format:**

```json
{
    "status": "successful",
    "message": "Feedback deleted successfully",
    "data": {
        "deleted_feedback_id": "feedback_001"
    }
}
```

---

### 8. Get Feedback Metadata/Analytics

**Endpoint:** `POST /api/educator-feedback/metadata`

**Purpose:** Get analytics and summary data for feedbacks

**Request Body:**

```json
{
    "grade": "Grade 10",
    "student_id": "std_001",
    "date_from": "2024-01-01",
    "date_to": "2024-12-31"
}
```

**Response Format:**

```json
{
    "status": "successful",
    "message": "Metadata retrieved successfully",
    "data": {
        "statistics": {
            "total_feedbacks": 150,
            "pending_approval": 12,
            "approved": 138,
            "rejected": 0,
            "average_rating": 4.2,
            "rating_distribution": {
                "5.0": 45,
                "4.0": 38,
                "3.0": 25,
                "2.0": 10,
                "1.0": 2
            }
        },
        "category_breakdown": {
            "Academic Performance": 65,
            "Behavioral Development": 35,
            "Social Skills": 20,
            "Creative Arts": 15,
            "Physical Development": 10,
            "Leadership Qualities": 5
        },
        "monthly_trends": [
            {
                "month": "2024-01",
                "feedbacks_count": 25,
                "average_rating": 4.1
            }
        ],
        "top_educators": [
            {
                "educator_id": "edu_001",
                "educator_name": "Ms. Sarah Johnson",
                "feedbacks_count": 45,
                "average_rating": 4.5
            }
        ]
    }
}
```

---

## Database Structure

### 6. feedback_categories table

```sql
CREATE TABLE feedback_categories (
    id VARCHAR(50) PRIMARY KEY,
    school_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    subcategories JSON, -- Array of subcategory strings
    sort_order INT DEFAULT 0,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_school_id (school_id),
    INDEX idx_sort_order (sort_order),
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);
```

### 7. feedback_questions table

```sql
CREATE TABLE feedback_questions (
    id VARCHAR(50) PRIMARY KEY,
    category_id VARCHAR(50) NOT NULL,
    question TEXT NOT NULL,
    answer_type ENUM('scale', 'predefined', 'custom') NOT NULL,
    is_required BOOLEAN DEFAULT TRUE,
    sort_order INT DEFAULT 0,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_category_id (category_id),
    INDEX idx_sort_order (sort_order),
    FOREIGN KEY (category_id) REFERENCES feedback_categories(id) ON DELETE CASCADE
);
```

### 8. feedback_question_options table

```sql
CREATE TABLE feedback_question_options (
    id VARCHAR(50) PRIMARY KEY,
    question_id VARCHAR(50) NOT NULL,
    text TEXT NOT NULL,
    marks INT NOT NULL DEFAULT 0,
    sort_order INT DEFAULT 0,
    active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_question_id (question_id),
    INDEX idx_sort_order (sort_order),
    FOREIGN KEY (question_id) REFERENCES feedback_questions(id) ON DELETE CASCADE
);
```

### 9. educator_feedbacks table

```sql
CREATE TABLE educator_feedbacks (
    id VARCHAR(50) PRIMARY KEY,
    student_id VARCHAR(50) NOT NULL,
    educator_id VARCHAR(50) NOT NULL,
    main_category VARCHAR(50) NOT NULL,
    subcategories JSON, -- Array of subcategory strings
    description TEXT NOT NULL,
    rating DECIMAL(3,2) NOT NULL DEFAULT 0.00,
    questionnaire_answers JSON, -- Store all questionnaire responses
    status ENUM('pending', 'approved', 'rejected', 'revision_requested') DEFAULT 'pending',
    created_by VARCHAR(50) NOT NULL,
    approved_by VARCHAR(50) NULL,
    approved_at TIMESTAMP NULL,
    revision_instructions TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_student_id (student_id),
    INDEX idx_educator_id (educator_id),
    INDEX idx_category (main_category),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at),
    INDEX idx_rating (rating),
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (educator_id) REFERENCES educators(id) ON DELETE CASCADE,
    FOREIGN KEY (main_category) REFERENCES feedback_categories(id) ON DELETE RESTRICT
);
```

### 10. feedback_analytics table (optional - for caching)

```sql
CREATE TABLE feedback_analytics (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    school_id BIGINT UNSIGNED NOT NULL,
    student_id VARCHAR(50),
    educator_id VARCHAR(50),
    grade_id VARCHAR(50),
    category_id VARCHAR(50),
    month CHAR(7), -- Format: YYYY-MM
    total_feedbacks INT DEFAULT 0,
    average_rating DECIMAL(3,2) DEFAULT 0.00,
    pending_count INT DEFAULT 0,
    approved_count INT DEFAULT 0,
    rejected_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY unique_analytics (school_id, student_id, educator_id, grade_id, category_id, month),
    INDEX idx_month (month),
    FOREIGN KEY (school_id) REFERENCES schools(id) ON DELETE CASCADE
);
```

---

## Laravel Implementation Guide

### 1. Controller Structure

```php
<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\EducatorFeedbackService;
use App\Http\Requests\EducatorFeedback\{
    CreateFeedbackRequest,
    UpdateFeedbackRequest,
    ListFeedbackRequest
};

class EducatorFeedbackController extends Controller
{
    protected $feedbackService;

    public function __construct(EducatorFeedbackService $feedbackService)
    {
        $this->feedbackService = $feedbackService;
    }

    public function getGrades()
    {
        return $this->feedbackService->getGradesList();
    }

    public function getStudentsByGrade(Request $request)
    {
        return $this->feedbackService->getStudentsByGrade(
            $request->grade,
            $request->search_phrase
        );
    }

    public function getCategoriesWithQuestions()
    {
        return $this->feedbackService->getCategoriesWithQuestions();
    }

    public function listFeedbacks(ListFeedbackRequest $request)
    {
        return $this->feedbackService->listFeedbacks($request->validated());
    }

    public function createFeedback(CreateFeedbackRequest $request)
    {
        return $this->feedbackService->createFeedback($request->validated());
    }

    public function updateFeedback(UpdateFeedbackRequest $request)
    {
        return $this->feedbackService->updateFeedback($request->validated());
    }

    public function deleteFeedback(Request $request)
    {
        return $this->feedbackService->deleteFeedback($request->feedback_id);
    }

    public function getMetadata(Request $request)
    {
        return $this->feedbackService->getMetadata($request->all());
    }
}
```

### 2. Service Layer

```php
<?php

namespace App\Services;

use App\Models\{Grade, Student, FeedbackCategory, EducatorFeedback};
use Illuminate\Support\Facades\DB;

class EducatorFeedbackService
{
    public function getGradesList()
    {
        $grades = Grade::where('active', true)
            ->withCount('students')
            ->orderBy('level')
            ->get()
            ->map(function ($grade) {
                return [
                    'id' => $grade->id,
                    'name' => $grade->name,
                    'students_count' => $grade->students_count,
                    'active' => $grade->active
                ];
            });

        return response()->json([
            'status' => 'successful',
            'message' => 'Grades retrieved successfully',
            'data' => ['grades' => $grades]
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
                'total_count' => $students->count()
            ]
        ]);
    }

    public function getCategoriesWithQuestions()
    {
        $categories = FeedbackCategory::with(['questions.options'])
            ->where('active', true)
            ->orderBy('sort_order')
            ->get();

        return response()->json([
            'status' => 'successful',
            'message' => 'Categories and questions retrieved successfully',
            'data' => ['categories' => $categories]
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
                'created_by' => auth()->id()
            ]);

            DB::commit();

            return response()->json([
                'status' => 'successful',
                'message' => 'Feedback submitted successfully',
                'data' => ['feedback' => $feedback]
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to submit feedback: ' . $e->getMessage()
            ], 500);
        }
    }

    private function calculateRatingFromAnswers($answers)
    {
        if (empty($answers)) return 0;

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
}
```

### 3. Models

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EducatorFeedback extends Model
{
    protected $fillable = [
        'school_id', 'student_id', 'educator_id', 'main_category',
        'subcategories', 'description', 'rating', 'questionnaire_answers',
        'status', 'created_by', 'approved_by', 'approved_at', 'revision_instructions'
    ];

    protected $casts = [
        'subcategories' => 'array',
        'questionnaire_answers' => 'array',
        'rating' => 'decimal:2',
        'approved_at' => 'datetime'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function educator()
    {
        return $this->belongsTo(User::class, 'educator_id');
    }

    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class, 'main_category');
    }
}

class FeedbackCategory extends Model
{
    protected $fillable = [
        'id', 'school_id', 'name', 'description', 'subcategories', 'sort_order', 'active'
    ];

    protected $casts = [
        'subcategories' => 'array'
    ];

    public function questions()
    {
        return $this->hasMany(FeedbackQuestion::class, 'category_id');
    }
}

class FeedbackQuestion extends Model
{
    protected $fillable = [
        'id', 'category_id', 'question', 'answer_type', 'is_required', 'sort_order', 'active'
    ];

    public function options()
    {
        return $this->hasMany(FeedbackQuestionOption::class, 'question_id');
    }
}
```

### 4. Routes

```php
// routes/api.php
Route::group(['prefix' => 'educator-feedback', 'middleware' => 'auth:api'], function () {
    Route::get('categories/with-questions', [EducatorFeedbackController::class, 'getCategoriesWithQuestions']);
    Route::post('feedbacks/list', [EducatorFeedbackController::class, 'listFeedbacks']);
    Route::post('feedbacks/create', [EducatorFeedbackController::class, 'createFeedback']);
    Route::post('feedbacks/update', [EducatorFeedbackController::class, 'updateFeedback']);
    Route::post('feedbacks/delete', [EducatorFeedbackController::class, 'deleteFeedback']);
    Route::post('metadata', [EducatorFeedbackController::class, 'getMetadata']);
});
```

---

## Frontend Integration Instructions

### 1. Update Store Configuration

Add the new API and slice to your store:

```typescript
// src/state-store/store.ts
import { educatorFeedbackApi } from "../api/educator-feedback-api";
import educatorFeedbackReducer from "./slices/educator/educatorFeedbackSliceWithAPI";

const rootReducer = combineReducers({
    // ... existing reducers
    educatorFeedback: educatorFeedbackReducer,
    apiServer1: apiServer1.reducer,
});

export const store = configureStore({
    reducer: rootReducer,
    middleware: (getDefaultMiddleware) =>
        getDefaultMiddleware({
            serializableCheck: {
                ignoredActions: [
                    FLUSH,
                    REHYDRATE,
                    PAUSE,
                    PERSIST,
                    PURGE,
                    REGISTER,
                ],
            },
        }).concat(
            apiServer1.middleware
            // ... other middleware
        ),
});
```

### 2. Update Modal Component

Replace mock data with real API calls:

```typescript
// In your EducatorFeedbackModal component
import {
    useGetGradesListQuery,
    useGetStudentsByGradeQuery,
    useGetFeedbackCategoriesWithQuestionsQuery,
    useSubmitEducatorFeedbackMutation,
} from "../../api/educator-feedback-api";

// Use real data
const { data: gradesData } = useGetGradesListQuery();
const { data: studentsData } = useGetStudentsByGradeQuery(
    { grade: selectedGradeForStudent },
    { skip: !selectedGradeForStudent }
);
const { data: categoriesData } = useGetFeedbackCategoriesWithQuestionsQuery();
```

### 3. Environment Variables

Add to your `.env` file:

```
EXPO_PUBLIC_BASE_URL_API_SERVER_1=https://your-backend-domain.com/
```

---

## Testing Checklist

### Backend Testing

-   [ ] All API endpoints return correct response format
-   [ ] Proper error handling for invalid requests
-   [ ] Database constraints work correctly
-   [ ] Authentication middleware works
-   [ ] Rating calculation algorithm is accurate

### Frontend Testing

-   [ ] Grade selection works and filters students correctly
-   [ ] Questionnaire system calculates ratings properly
-   [ ] Form validation prevents invalid submissions
-   [ ] Real-time data updates work with RTK Query
-   [ ] Error states display user-friendly messages

### Integration Testing

-   [ ] Complete feedback submission flow works end-to-end
-   [ ] Data persistence across app sessions
-   [ ] Performance with large datasets
-   [ ] Network error handling and retry logic

---

This comprehensive backend specification ensures a robust, scalable educator feedback system that integrates seamlessly with your React Native frontend.
