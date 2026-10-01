<?php

namespace Modules\CommunicationManagement\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\CommunicationManagement\Models\NotificationType;

class NotificationTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'name' => 'System',
                'slug' => 'system',
                'description' => 'System-generated notifications and alerts',
                'icon' => 'cog',
                'color' => '#6b7280',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'name' => 'Announcement',
                'slug' => 'announcement',
                'description' => 'General announcements and notices',
                'icon' => 'megaphone',
                'color' => '#3b82f6',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'name' => 'Academic',
                'slug' => 'academic',
                'description' => 'Academic-related notifications (grades, assignments, etc.)',
                'icon' => 'book-open',
                'color' => '#10b981',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'name' => 'Event',
                'slug' => 'event',
                'description' => 'Event reminders and updates',
                'icon' => 'calendar',
                'color' => '#f59e0b',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'name' => 'Alert',
                'slug' => 'alert',
                'description' => 'Important alerts and urgent messages',
                'icon' => 'exclamation-triangle',
                'color' => '#ef4444',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'name' => 'Attendance',
                'slug' => 'attendance',
                'description' => 'Attendance-related notifications',
                'icon' => 'user-check',
                'color' => '#8b5cf6',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'name' => 'Financial',
                'slug' => 'financial',
                'description' => 'Bills, payments, and financial notices',
                'icon' => 'credit-card',
                'color' => '#06b6d4',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'name' => 'Social',
                'slug' => 'social',
                'description' => 'Social feed and activity notifications',
                'icon' => 'users',
                'color' => '#ec4899',
                'is_active' => true,
                'created_by' => 1,
            ],
        ];

        foreach ($types as $type) {
            NotificationType::updateOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }
    }
}
