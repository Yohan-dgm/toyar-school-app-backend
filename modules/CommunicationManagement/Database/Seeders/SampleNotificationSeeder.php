<?php

namespace Modules\CommunicationManagement\Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Modules\CommunicationManagement\Models\Notification;
use Modules\CommunicationManagement\Models\NotificationRecipient;
use Modules\CommunicationManagement\Models\NotificationType;
use Modules\UserManagement\Models\User;

class SampleNotificationSeeder extends Seeder
{
    public function run()
    {
        // Get notification types
        $announcementType = NotificationType::where('slug', 'announcement')->first();
        $eventType = NotificationType::where('slug', 'event')->first();
        $alertType = NotificationType::where('slug', 'alert')->first();
        $academicType = NotificationType::where('slug', 'academic')->first();
        $attendanceType = NotificationType::where('slug', 'attendance')->first();

        // Get some users for testing
        $users = User::where('is_active', true)->limit(10)->pluck('id')->toArray();

        if (empty($users)) {
            $this->command->info('No active users found. Skipping sample notifications.');

            return;
        }

        $notifications = [
            [
                'notification_type_id' => $announcementType?->id ?? 1,
                'title' => 'Welcome to New Academic Year 2025',
                'message' => 'We are excited to welcome all students and parents to the new academic year 2025. This year brings new opportunities and exciting changes to our curriculum.',
                'priority' => 'normal',
                'target_type' => 'broadcast',
                'target_data' => [],
                'action_url' => '/academic/year-2025',
                'action_text' => 'View Details',
                'school_id' => 1,
                'created_by' => 1,
                'sent_at' => Carbon::now()->subHours(2),
            ],
            [
                'notification_type_id' => $eventType?->id ?? 2,
                'title' => 'Parent-Teacher Meeting Scheduled',
                'message' => 'Parent-Teacher meetings have been scheduled for August 25th, 2025. Please check your individual schedules for specific timings.',
                'priority' => 'high',
                'target_type' => 'role',
                'target_data' => ['roles' => ['parent', 'teacher']],
                'action_url' => '/events/parent-teacher-meeting',
                'action_text' => 'Book Slot',
                'school_id' => 1,
                'created_by' => 1,
                'sent_at' => Carbon::now()->subHour(),
            ],
            [
                'notification_type_id' => $alertType?->id ?? 3,
                'title' => 'Emergency School Closure Notice',
                'message' => 'Due to severe weather conditions, the school will be closed tomorrow (August 12th, 2025). All classes are cancelled and will resume on August 13th.',
                'priority' => 'urgent',
                'target_type' => 'broadcast',
                'target_data' => [],
                'expires_at' => Carbon::now()->addDays(2),
                'school_id' => 1,
                'created_by' => 1,
                'sent_at' => Carbon::now()->subMinutes(30),
            ],
            [
                'notification_type_id' => $academicType?->id ?? 4,
                'title' => 'Grade 10 Mathematics Assignment Due',
                'message' => 'Reminder: Your Mathematics assignment on Trigonometry is due on August 15th, 2025. Please submit your work on time.',
                'priority' => 'normal',
                'target_type' => 'class',
                'target_data' => ['grade_level_class_ids' => [10]],
                'action_url' => '/assignments/math-trigonometry',
                'action_text' => 'Submit Assignment',
                'is_scheduled' => true,
                'scheduled_at' => Carbon::now()->addDay(),
                'expires_at' => Carbon::now()->addDays(4),
                'school_id' => 1,
                'created_by' => 1,
            ],
            [
                'notification_type_id' => $attendanceType?->id ?? 5,
                'title' => 'Attendance Alert - Multiple Absences',
                'message' => 'Your child has been absent for 3 consecutive days. Please contact the school office to discuss this matter.',
                'priority' => 'high',
                'target_type' => 'user',
                'target_data' => ['user_ids' => [array_slice($users, 0, 2)]],
                'action_url' => '/attendance/student/view',
                'action_text' => 'View Attendance',
                'school_id' => 1,
                'created_by' => 1,
                'sent_at' => Carbon::now()->subMinutes(45),
            ],
        ];

        foreach ($notifications as $notificationData) {
            $notification = Notification::create($notificationData);

            // Create sample recipients
            $recipients = [];
            $targetType = $notificationData['target_type'];

            switch ($targetType) {
                case 'broadcast':
                    $recipients = $users;
                    break;
                case 'user':
                    $recipients = $notificationData['target_data']['user_ids'] ?? array_slice($users, 0, 2);
                    break;
                case 'role':
                case 'class':
                default:
                    $recipients = array_slice($users, 0, 5);
                    break;
            }

            // Create recipient records
            foreach ($recipients as $userId) {
                $isRead = rand(1, 100) <= 30; // 30% chance of being read
                $readAt = $isRead ? Carbon::now()->subMinutes(rand(1, 120)) : null;

                NotificationRecipient::create([
                    'notification_id' => $notification->id,
                    'user_id' => $userId,
                    'is_read' => $isRead,
                    'read_at' => $readAt,
                    'is_delivered' => true,
                    'delivered_at' => $notification->sent_at ?? Carbon::now(),
                    'delivery_method' => 'in_app',
                ]);
            }

            // Update notification stats
            $notification->update([
                'total_recipients' => count($recipients),
                'total_sent' => count($recipients),
                'total_delivered' => count($recipients),
                'total_read' => NotificationRecipient::where('notification_id', $notification->id)
                    ->where('is_read', true)
                    ->count(),
            ]);
        }

        $this->command->info('Sample notifications created successfully!');
    }
}
