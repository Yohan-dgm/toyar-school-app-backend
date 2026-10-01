<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
// Import the intents
use Modules\EducatorFeedbackManagement\Intents\Category\CreateCategory\CreateCategoryIntent;
use Modules\EducatorFeedbackManagement\Intents\Category\DeleteCategory\DeleteCategoryIntent;
use Modules\EducatorFeedbackManagement\Intents\Category\UpdateCategory\UpdateCategoryIntent;
use Modules\EducatorFeedbackManagement\Intents\Comment\CreateComment\CreateCommentIntent;
use Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\CreateEducatorFeedback\CreateEducatorFeedbackIntent;
use Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\DeleteEducatorFeedback\DeleteEducatorFeedbackIntent;
use Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\GetEducatorFeedbackListData\GetEducatorFeedbackListDataIntent;
use Modules\EducatorFeedbackManagement\Intents\EducatorFeedback\UpdateEducatorFeedback\UpdateEducatorFeedbackIntent;
use Modules\EducatorFeedbackManagement\Intents\Evaluation\CreateEvaluation\CreateEvaluationIntent;
use Modules\EducatorFeedbackManagement\Intents\Evaluation\DeleteEvaluation\DeleteEvaluationIntent;
use Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluation\UpdateEvaluationIntent;
use Modules\EducatorFeedbackManagement\Intents\Evaluation\UpdateEvaluationStatus\UpdateEvaluationStatusIntent;
use Modules\EducatorFeedbackManagement\Intents\Metadata\GetEducatorFeedbackMetadata\GetEducatorFeedbackMetadataIntent;

// Educator Feedback Management API Routes
Route::group(['prefix' => 'educator-feedback-management', 'middleware' => AuthGuard::class], function () {

    // Main Educator Feedback CRUD Operations - Full CRUD
    Route::post('feedback/list', GetEducatorFeedbackListDataIntent::class);
    Route::post('feedback/create', CreateEducatorFeedbackIntent::class);
    Route::post('feedback/update', UpdateEducatorFeedbackIntent::class);
    Route::post('feedback/delete', DeleteEducatorFeedbackIntent::class);

    // Category Management - Partial CRUD (list endpoint not implemented)
    // Route::post('category/list', GetCategoryListDataIntent::class); // Intent does not exist
    Route::post('category/create', CreateCategoryIntent::class);
    Route::post('category/update', UpdateCategoryIntent::class);
    Route::post('category/delete', DeleteCategoryIntent::class);

    // Evaluation Management
    Route::post('evaluation/create', CreateEvaluationIntent::class);
    Route::post('evaluation/update', UpdateEvaluationIntent::class);
    Route::post('evaluation/delete', DeleteEvaluationIntent::class);
    Route::post('evaluation/update-status', UpdateEvaluationStatusIntent::class);

    // Comment Management
    Route::post('comment/create', CreateCommentIntent::class);

    // Metadata Endpoints
    Route::post('metadata', GetEducatorFeedbackMetadataIntent::class);

});
