<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
// Import the intents
use Modules\EducatorFeedbackManagement\Intents\Category\CreateCategory\CreateCategoryIntent;
use Modules\EducatorFeedbackManagement\Intents\Category\DeleteCategory\DeleteCategoryIntent;
use Modules\EducatorFeedbackManagement\Intents\Category\UpdateCategory\UpdateCategoryIntent;
// Section-specific category intents
use Modules\EducatorFeedbackManagement\Intents\CategoryEy\GetCategoryEyListData\GetCategoryEyListDataIntent;
use Modules\EducatorFeedbackManagement\Intents\CategoryPr\GetCategoryPrListData\GetCategoryPrListDataIntent;
use Modules\EducatorFeedbackManagement\Intents\CategorySc\GetCategoryScListData\GetCategoryScListDataIntent;
use Modules\EducatorFeedbackManagement\Intents\Comment\CreateComment\CreateCommentIntent;
use Modules\EducatorFeedbackManagement\Intents\Dashboard\GetStudentRatingByTerm\GetStudentRatingByTermIntent;
use Modules\EducatorFeedbackManagement\Intents\ParentComment\CreateParentComment\CreateParentCommentIntent;
use Modules\EducatorFeedbackManagement\Intents\ParentComment\DeleteParentComment\DeleteParentCommentIntent;
use Modules\EducatorFeedbackManagement\Intents\ParentComment\GetParentCommentList\GetParentCommentListIntent;
use Modules\EducatorFeedbackManagement\Intents\ParentComment\UpdateParentComment\UpdateParentCommentIntent;
use Modules\EducatorFeedbackManagement\Intents\Dashboard\GetStudentRatingDashboard\GetStudentRatingDashboardIntent;
use Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\CreateEducatorFeedback\CreateEducatorFeedbackIntent;
use Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\DeleteEducatorFeedback\DeleteEducatorFeedbackIntent;
use Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\GetEducatorFeedbackListData\GetEducatorFeedbackListDataIntent;
use Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\GetMyFeedbackList\GetMyFeedbackListIntent;
use Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\UpdateEducatorFeedback\UpdateEducatorFeedbackIntent;
use Modules\EducatorFeedbackManagement\Intents\Evaluation\CreateEvaluation\CreateEvaluationIntent;
use Modules\EducatorFeedbackManagement\Intents\Evaluation\DeleteEvaluation\DeleteEvaluationIntent;
use Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluation\UpdateEvaluationIntent;
use Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluationStatus\UpdateEvaluationStatusIntent;
use Modules\EducatorFeedbackManagement\Intents\Metadata\GetEducatorFeedbackMetadata\GetEducatorFeedbackMetadataIntent;
use Modules\EducatorFeedbackManagement\Intents\Stats\GetEducatorFeedbackStats\GetEducatorFeedbackStatsIntent;
use Modules\EducatorFeedbackManagement\Intents\Stats\GetStudentFeedbackStats\GetStudentFeedbackStatsIntent;
use Modules\EducatorFeedbackManagement\Intents\StudentCategoryFeedback\GetStudentCategoryFeedbackList\GetStudentCategoryFeedbackListIntent;

// Educator Feedback Management API Routes
Route::group(['middleware' => AuthGuard::class], function () {

    // Main Educator Feedback CRUD Operations - Full CRUD
    Route::post('feedback/list', GetEducatorFeedbackListDataIntent::class);
    Route::post('feedback/my-list', GetMyFeedbackListIntent::class);
    Route::post('feedback/create', CreateEducatorFeedbackIntent::class);
    Route::post('feedback/update', UpdateEducatorFeedbackIntent::class);
    Route::post('feedback/delete', DeleteEducatorFeedbackIntent::class);

    // Section-specific Category Management
    Route::post('category/ey/list', GetCategoryEyListDataIntent::class);
    Route::post('category/pr/list', GetCategoryPrListDataIntent::class);
    Route::post('category/sc/list', GetCategoryScListDataIntent::class);
    
    // Category Management - CRUD (still available for general operations)
    Route::post('category/create', CreateCategoryIntent::class);
    Route::post('category/update', UpdateCategoryIntent::class);
    Route::post('category/delete', DeleteCategoryIntent::class);

    // Comment Management
    Route::post('comment/create', CreateCommentIntent::class);

    // Parent Comment Management
    Route::post('parent-comment/list', GetParentCommentListIntent::class);
    Route::post('parent-comment/create', CreateParentCommentIntent::class);
    Route::post('parent-comment/update', UpdateParentCommentIntent::class);
    Route::post('parent-comment/delete', DeleteParentCommentIntent::class);

    // Evaluation Management
    Route::post('evaluation/create', CreateEvaluationIntent::class);
    Route::post('evaluation/update', UpdateEvaluationIntent::class);
    Route::post('evaluation/delete', DeleteEvaluationIntent::class);
    Route::post('evaluation/update-status', UpdateEvaluationStatusIntent::class);

    // Metadata Endpoints
    Route::post('metadata', GetEducatorFeedbackMetadataIntent::class);

    // Dashboard Endpoints
    Route::post('dashboard/student-ratings', GetStudentRatingDashboardIntent::class);
    Route::post('dashboard/student-ratings-by-term', GetStudentRatingByTermIntent::class);

    // Student Category Feedback Endpoints
    Route::post('student-category-feedback/list', GetStudentCategoryFeedbackListIntent::class);

    // Statistics Endpoints
    Route::post('stats/educator-feedback-counts', GetEducatorFeedbackStatsIntent::class);
    Route::post('stats/student-feedback-counts', GetStudentFeedbackStatsIntent::class);

});
