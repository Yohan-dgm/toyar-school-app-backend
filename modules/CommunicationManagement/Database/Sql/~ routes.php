<?php

use App\Middleware\AuthGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\CommunicationManagement\Intents\Notification\CreateNotification\CreateNotificationIntent;
use Modules\CommunicationManagement\Intents\Notification\GetUserNotifications\GetUserNotificationsIntent;
use Modules\CommunicationManagement\Intents\Notification\MarkAsRead\MarkAsReadIntent;
use Modules\CommunicationManagement\Intents\Notification\DeleteNotification\DeleteNotificationIntent;
use Modules\CommunicationManagement\Intents\Notification\GetNotificationDetails\GetNotificationDetailsIntent;
use Modules\CommunicationManagement\Intents\Announcement\CreateAnnouncement\CreateAnnouncementIntent;
use Modules\CommunicationManagement\Intents\Announcement\GetAnnouncements\GetAnnouncementsIntent;
use Modules\CommunicationManagement\Intents\Announcement\GetAnnouncementDetails\GetAnnouncementDetailsIntent;

// Notification Management Routes - All routes require authentication
Route::prefix('notifications')->middleware(AuthGuard::class)->group(function () {
    
    // Create notification (Admin/Teacher only)
    // POST /api/communication-management/notifications/create
    Route::post('/create', CreateNotificationIntent::class)
        ->name('notifications.create');
    
    // Get user's notifications (paginated with filters)
    // POST /api/communication-management/notifications/list
    Route::post('/list', GetUserNotificationsIntent::class)
        ->name('notifications.list');
    
    // Mark notification as read (single or all)
    // POST /api/communication-management/notifications/mark-read
    Route::post('/mark-read', MarkAsReadIntent::class)
        ->name('notifications.mark-read');
    
    // Delete notification (remove from user's view)
    // POST /api/communication-management/notifications/delete
    Route::post('/delete', DeleteNotificationIntent::class)
        ->name('notifications.delete');
    
    // Get notification details (auto-marks as read)
    // POST /api/communication-management/notifications/details
    Route::post('/details', GetNotificationDetailsIntent::class)
        ->name('notifications.details');
});

// Announcement Management Routes - All routes require authentication
Route::prefix('announcements')->group(function () {
    
    // Create announcement
    // POST /api/communication-management/announcements/create
    Route::post('/create', CreateAnnouncementIntent::class)
        ->name('announcements.create');
    
    // Get announcements list (with filtering)
    // POST /api/communication-management/announcements/list
    Route::post('/list', GetAnnouncementsIntent::class)
        ->name('announcements.list');
    
    // Get announcement details
    // POST /api/communication-management/announcements/details
    Route::post('/details', GetAnnouncementDetailsIntent::class)
        ->name('announcements.details');
    
    // Update announcement
    // POST /api/communication-management/announcements/update
    // Route::post('/update', UpdateAnnouncementIntent::class)
    //     ->name('announcements.update');
    
    // Publish announcement
    // POST /api/communication-management/announcements/publish
    // Route::post('/publish', PublishAnnouncementIntent::class)
    //     ->name('announcements.publish');
});

// API Endpoint Documentation:
//
// 1. Create Notification
//    POST /api/communication-management/notifications/create
//    Body: {
//        "notification_type_id": 1,
//        "title": "Test Notification",
//        "message": "This is a test notification",
//        "priority": "normal|high|urgent",
//        "target_type": "broadcast|user|role|class|grade|school",
//        "target_data": {
//            "user_id": 123,                    // for target_type: user
//            "user_ids": [1,2,3],               // for target_type: user (multiple)
//            "roles": ["parent", "teacher"],     // for target_type: role  
//            "grade_level_class_ids": [1,2],    // for target_type: class
//            "grade_level_ids": [1,2]           // for target_type: grade
//        },
//        "action_url": "/some/action",          // optional
//        "action_text": "View Details",        // optional
//        "image_url": "/path/to/image.jpg",    // optional
//        "is_scheduled": false,                // optional
//        "scheduled_at": "2025-08-15T10:00:00Z", // optional
//        "expires_at": "2025-08-30T23:59:59Z", // optional
//        "school_id": 1                        // optional
//    }
//
// 2. Get User Notifications
//    POST /api/communication-management/notifications/list
//    Body: {
//        "page": 1,                            // optional, default: 1
//        "per_page": 20,                       // optional, default: 20, max: 100
//        "filter": "all|read|unread|delivered|pending", // optional
//        "priority": "normal|high|urgent",     // optional
//        "type_id": 1,                        // optional
//        "search": "search term",             // optional
//        "unread_only": true                  // optional
//    }
//
// 3. Mark as Read
//    POST /api/communication-management/notifications/mark-read
//    Body: {
//        "notification_id": 123,
//        "mark_all": false                    // optional, if true marks all unread as read
//    }
//
// 4. Delete Notification
//    POST /api/communication-management/notifications/delete
//    Body: {
//        "notification_id": 123
//    }
//
// 5. Get Notification Details
//    POST /api/communication-management/notifications/details
//    Body: {
//        "notification_id": 123
//    }
//
// All endpoints return JSON responses with the following structure:
// Success: { "success": true, "message": "...", "data": {...} }
// Error: { "success": false, "message": "...", "errors": {...} }
//
// 6. Create Announcement
//    POST /api/communication-management/announcements/create
//    Body: {
//        "title": "Announcement Title",
//        "content": "Full announcement content",
//        "excerpt": "Short preview text",          // optional
//        "category_id": 1,
//        "priority_level": 2,                      // 1=Low, 2=Medium, 3=High
//        "status": "published",                    // draft|scheduled|published
//        "target_type": "broadcast",               // broadcast|role|class|grade|user
//        "target_data": {                         // optional, based on target_type
//            "roles": ["student", "parent"],
//            "user_ids": [1, 2, 3],
//            "grade_level_class_ids": [1, 2]
//        },
//        "image_url": "/path/to/image.jpg",       // optional
//        "attachment_urls": ["/file1.pdf"],       // optional
//        "is_featured": false,                    // optional
//        "is_pinned": false,                      // optional
//        "scheduled_at": "2025-08-15T10:00:00Z", // optional, for scheduled status
//        "expires_at": "2025-08-30T23:59:59Z",   // optional
//        "school_id": 1,                         // optional
//        "tags": "important,urgent,academic",     // optional
//        "meta_data": {"key": "value"}           // optional
//    }