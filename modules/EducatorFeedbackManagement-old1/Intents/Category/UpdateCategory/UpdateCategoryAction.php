<?php

namespace Modules\EducatorFeedbackManagement\Intents\Category\UpdateCategory;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\EducatorFeedbackManagement\Models\EduFbCategory;
use Modules\LogManagement\Intents\StudentLog\CreateStudentLog\CreateStudentLogAction;

class UpdateCategoryAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation
        $updateCategoryUserDTO = UpdateCategoryUserDTO::validate($payloadArray);

        // Find the category
        $category = EduFbCategory::findOrFail($updateCategoryUserDTO['id']);

        // Store original values for logging
        $originalName = $category->name;
        $originalStatus = $category->is_active;

        // Update category
        $category->update([
            'name' => $updateCategoryUserDTO['name'],
            'is_active' => $updateCategoryUserDTO['is_active'] ?? $category->is_active,
            'updated_by' => $actionData['user_id'],
        ]);

        // Create activity log
        if (array_key_exists('username', $actionData)) {
            $changes = [];
            if ($originalName !== $updateCategoryUserDTO['name']) {
                $changes[] = "Name: {$originalName} → {$updateCategoryUserDTO['name']}";
            }
            if ($originalStatus !== ($updateCategoryUserDTO['is_active'] ?? $category->is_active)) {
                $newStatus = ($updateCategoryUserDTO['is_active'] ?? $category->is_active) ? 'Active' : 'Inactive';
                $oldStatus = $originalStatus ? 'Active' : 'Inactive';
                $changes[] = "Status: {$oldStatus} → {$newStatus}";
            }

            $logData['description'] = '[STATUS: Successfully Updated Category, IP: '.$_SERVER['REMOTE_ADDR'].', USER: '.$actionData['username'].', CATEGORY ID: '.$category->id.', CHANGES: '.implode(', ', $changes).']';
            $logData['user_name'] = $actionData['username'];
            CreateStudentLogAction::run($logData, ['created_by' => $actionData['user_id']]);
        }

        // Load relationships for response
        $category->load([
            'created_by:id,call_name_with_title',
            'updated_by:id,call_name_with_title',
        ]);

        return $category;
    }
}
