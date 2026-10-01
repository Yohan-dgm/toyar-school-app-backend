<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\DeleteCategory;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFbCategory;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class DeleteCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $deleteCategoryUserDTO = DeleteCategoryUserDTO::validate($payloadArray);

        // Find the category
        $category = EduFbCategory::findOrFail($deleteCategoryUserDTO['id']);

        // Check if category has associated feedback records
        $feedbackCount = $category->feedback_list()->count();
        $questionsCount = $category->predefined_questions()->count();
        $subcategoriesCount = $category->subcategories()->count();

        if ($feedbackCount > 0) {
            throw new \Exception("Cannot delete category '{$category->name}' because it has {$feedbackCount} associated feedback records. Please remove all feedback records first or set the category as inactive.");
        }

        // Store category data for logging before deletion
        $categoryName = $category->name;
        $categoryId = $category->id;

        // Use database transaction for safety
        return DB::transaction(function () use ($category, $categoryName, $categoryId, $questionsCount, $subcategoriesCount, $actionData) {

            // Delete related records first (cascading delete)
            if ($questionsCount > 0) {
                // Delete predefined answers first
                foreach ($category->predefined_questions as $question) {
                    $question->predefined_answers()->delete();
                }
                // Delete predefined questions
                $category->predefined_questions()->delete();
            }

            if ($subcategoriesCount > 0) {
                // Delete subcategories
                $category->subcategories()->delete();
            }

            // Delete the category
            $category->delete();

            // Create activity log
            if (array_key_exists('username', $actionData)) {
                $logData['description'] = '[STATUS: Successfully Deleted Category, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].", CATEGORY: {$categoryName}, ID: {$categoryId}, QUESTIONS DELETED: {$questionsCount}, SUBCATEGORIES DELETED: {$subcategoriesCount}]";
                $logData['user_name'] = $actionData['username'];
                CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
            }

            return [
                'deleted_category' => [
                    'id' => $categoryId,
                    'name' => $categoryName,
                    'questions_deleted' => $questionsCount,
                    'subcategories_deleted' => $subcategoriesCount,
                ],
            ];
        });
    }
}
