<?php

namespace Modules\CommunicationManagement\Policies;

use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;
use Modules\UserManagement\Models\User;

class NotificationPolicy
{
    /**
     * Determine if the user can create notifications
     */
    public function create(User $user): bool
    {
        // Only allow certain user categories to create notifications
        // This should be customized based on your role/permission system
        return in_array($user->user_category, ['admin', 'teacher', 'staff']);
    }

    /**
     * Determine if the user can view a specific notification
     */
    public function view(User $user, Notification $notification): bool
    {
        // Check if user is a recipient of this notification
        return NotificationRecipient::where('notification_id', $notification->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Determine if the user can update a notification
     */
    public function update(User $user, Notification $notification): bool
    {
        // Only the creator or admin can update notifications
        return $user->id === $notification->created_by ||
               $user->user_category === 'admin';
    }

    /**
     * Determine if the user can delete a notification (admin delete)
     */
    public function delete(User $user, Notification $notification): bool
    {
        // Only the creator or admin can delete notifications entirely
        return $user->id === $notification->created_by ||
               $user->user_category === 'admin';
    }

    /**
     * Determine if the user can remove a notification from their view
     */
    public function remove(User $user, Notification $notification): bool
    {
        // Users can remove notifications from their own view
        return NotificationRecipient::where('notification_id', $notification->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Determine if the user can mark a notification as read
     */
    public function markAsRead(User $user, Notification $notification): bool
    {
        // Users can mark their own notifications as read
        return NotificationRecipient::where('notification_id', $notification->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    /**
     * Determine if the user can send broadcast notifications
     */
    public function sendBroadcast(User $user): bool
    {
        // Only admins and authorized staff can send broadcast notifications
        return in_array($user->user_category, ['admin', 'principal', 'vice_principal']);
    }

    /**
     * Determine if the user can send urgent notifications
     */
    public function sendUrgent(User $user): bool
    {
        // Only admins and authorized staff can send urgent notifications
        return in_array($user->user_category, ['admin', 'principal', 'vice_principal', 'teacher']);
    }

    /**
     * Determine if the user can send scheduled notifications
     */
    public function sendScheduled(User $user): bool
    {
        // Allow admins and teachers to schedule notifications
        return in_array($user->user_category, ['admin', 'teacher', 'staff']);
    }

    /**
     * Determine if the user can send notifications to specific roles
     */
    public function sendToRole(User $user, array $roles): bool
    {
        // Admins can send to any role
        if ($user->user_category === 'admin') {
            return true;
        }

        // Teachers can send to students and parents
        if ($user->user_category === 'teacher') {
            $allowedRoles = ['student', 'parent'];

            return empty(array_diff($roles, $allowedRoles));
        }

        // Staff can send to students
        if ($user->user_category === 'staff') {
            return in_array('student', $roles) && count($roles) === 1;
        }

        return false;
    }

    /**
     * Determine if the user can send notifications to specific users
     */
    public function sendToUsers(User $user, array $userIds): bool
    {
        // Admins can send to anyone
        if ($user->user_category === 'admin') {
            return true;
        }

        // Teachers can send to their students and their parents
        if ($user->user_category === 'teacher') {
            return $this->canContactUsers($user, $userIds);
        }

        // Staff have limited sending capabilities
        if ($user->user_category === 'staff') {
            return $this->canContactUsers($user, $userIds);
        }

        return false;
    }

    /**
     * Determine if the user can view notification statistics
     */
    public function viewStats(User $user): bool
    {
        return in_array($user->user_category, ['admin', 'principal', 'vice_principal']);
    }

    /**
     * Determine if the user can manage notification types
     */
    public function manageTypes(User $user): bool
    {
        return $user->user_category === 'admin';
    }

    /**
     * Determine if the user can send notifications to a specific class
     */
    public function sendToClass(User $user, array $classIds): bool
    {
        // Admins can send to any class
        if ($user->user_category === 'admin') {
            return true;
        }

        // Teachers can send to classes they teach
        if ($user->user_category === 'teacher') {
            return $this->teachesClasses($user, $classIds);
        }

        return false;
    }

    /**
     * Determine if the user can send notifications to a specific grade
     */
    public function sendToGrade(User $user, array $gradeIds): bool
    {
        // Admins can send to any grade
        if ($user->user_category === 'admin') {
            return true;
        }

        // Teachers can send to grades they teach
        if ($user->user_category === 'teacher') {
            return $this->teachesGrades($user, $gradeIds);
        }

        return false;
    }

    /**
     * Check if user can contact specific users (implement based on your relationship logic)
     */
    private function canContactUsers(User $user, array $userIds): bool
    {
        // This would need to be implemented based on your specific business logic
        // For example, checking if teacher teaches these students, etc.
        return true; // Placeholder implementation
    }

    /**
     * Check if user teaches specific classes (implement based on your relationship logic)
     */
    private function teachesClasses(User $user, array $classIds): bool
    {
        // This would need to be implemented based on your teacher-class relationship
        return true; // Placeholder implementation
    }

    /**
     * Check if user teaches specific grades (implement based on your relationship logic)
     */
    private function teachesGrades(User $user, array $gradeIds): bool
    {
        // This would need to be implemented based on your teacher-grade relationship
        return true; // Placeholder implementation
    }
}
