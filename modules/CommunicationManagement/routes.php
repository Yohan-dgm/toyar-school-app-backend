<?php

use App\Middleware\AuthGuard;
use Illuminate\Support\Facades\Route;
use Modules\CommunicationManagement\Intents\Announcement\CreateAnnouncement\CreateAnnouncementIntent;
use Modules\CommunicationManagement\Intents\Announcement\GetAnnouncementDetails\GetAnnouncementDetailsIntent;
use Modules\CommunicationManagement\Intents\Announcement\GetAnnouncements\GetAnnouncementsIntent;
use Modules\CommunicationManagement\Intents\Notification\CreateNotification\CreateNotificationIntent;
use Modules\CommunicationManagement\Intents\Notification\DeleteNotification\DeleteNotificationIntent;
use Modules\CommunicationManagement\Intents\Notification\GetNotificationDetails\GetNotificationDetailsIntent;
use Modules\CommunicationManagement\Intents\Notification\GetNotificationStats\GetNotificationStatsIntent;
use Modules\CommunicationManagement\Intents\Notification\GetUserNotifications\GetUserNotificationsIntent;
use Modules\CommunicationManagement\Intents\Notification\MarkAsRead\MarkAsReadIntent;
// use Modules\CommunicationManagement\Intents\GetNotificationUserTypeListData\GetNotificationUserTypeListDataIntent;
// modules/CommunicationManagement/Intents/GetNotificationUserTypeListData/GetNotificationUserTypeListDataIntent.php
use Modules\CommunicationManagement\Intents\Notification\GetNotificationUserTypeListData\GetNotificationUserTypeListDataIntent;
use Modules\CommunicationManagement\Intents\Chat\GetChatThreads\GetChatThreadsIntent;
use Modules\CommunicationManagement\Intents\Chat\GetChatMessages\GetChatMessagesIntent;
use Modules\CommunicationManagement\Intents\Chat\SendChatMessage\SendChatMessageIntent;
use Modules\CommunicationManagement\Intents\Chat\CreateChatGroup\CreateChatGroupIntent;
use Modules\CommunicationManagement\Intents\Chat\MarkChatAsRead\MarkChatAsReadIntent;
use Modules\CommunicationManagement\Intents\Chat\UpdateChatMessage\UpdateChatMessageIntent;
use Modules\CommunicationManagement\Intents\Chat\DeleteChatMessage\DeleteChatMessageIntent;
use Modules\CommunicationManagement\Intents\Chat\GetMessageReadReceipts\GetMessageReadReceiptsIntent;
use Modules\CommunicationManagement\Intents\Chat\UploadChatMedia\UploadChatMediaInitIntent;
use Modules\CommunicationManagement\Intents\Chat\UploadChatMedia\UploadChatMediaPushIntent;
use Modules\CommunicationManagement\Intents\Chat\UploadChatMedia\UploadChatMediaFinishIntent;
use Modules\CommunicationManagement\Intents\Chat\UpdateChatGroup\UpdateChatGroupIntent;
use Modules\CommunicationManagement\Intents\Chat\AddChatGroupMembers\AddChatGroupMembersIntent;
use Modules\CommunicationManagement\Intents\Chat\RemoveChatGroupMember\RemoveChatGroupMemberIntent;
use Modules\CommunicationManagement\Intents\Chat\GetChatGroupMembers\GetChatGroupMembersIntent;
use Modules\CommunicationManagement\Intents\Chat\DeleteChatGroup\DeleteChatGroupIntent;
use Modules\CommunicationManagement\Intents\Chat\SearchChatUsers\SearchChatUsersIntent;
use Modules\CommunicationManagement\Intents\Chat\ToggleChatGroupPin\ToggleChatGroupPinIntent;
use Modules\CommunicationManagement\Intents\Chat\ToggleChatMessageReaction\ToggleChatMessageReactionIntent;
use Modules\CommunicationManagement\Intents\Chat\SetChatFocus\SetChatFocusIntent;
use Modules\CommunicationManagement\Intents\Chat\GetChatGroupMedia\GetChatGroupMediaIntent;
use Modules\CommunicationManagement\Intents\Chat\UploadVoiceNote\UploadVoiceNoteIntent;
use Modules\CommunicationManagement\Intents\Chat\SetChatGroupVoiceNote\SetChatGroupVoiceNoteIntent;
use Modules\CommunicationManagement\Intents\Chat\CreatePoll\CreatePollIntent;
use Modules\CommunicationManagement\Intents\Chat\VotePoll\VotePollIntent;
use Modules\CommunicationManagement\Intents\Chat\ClosePoll\ClosePollIntent;
use Modules\CommunicationManagement\Intents\Chat\GetPollDetails\GetPollDetailsIntent;
use Modules\CommunicationManagement\Intents\Chat\GetPollVoters\GetPollVotersIntent;

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

    // Get notification statistics
    // POST /api/communication-management/notifications/stats
    Route::post('/stats', GetNotificationStatsIntent::class)
        ->name('notifications.stats');
    
    // Route::middleware('auth:web')->post('/get-notification-user-type-list-data', GetNotificationUserTypeListDataIntent::class)->name('notification.get-notification-user-type-list-data');

});

// notification
Route::prefix('notification')->group(function () {
    Route::middleware(AuthGuard::class)->post('/get-notification-user-type-list-data', GetNotificationUserTypeListDataIntent::class)->name('notification.get-notification-user-type-list-data');
});

 

// Announcement Management Routes - All routes require authentication
Route::prefix('announcements')->middleware(AuthGuard::class)->group(function () {

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

    // Update announcement (TODO: Implement UpdateAnnouncementIntent)
    // POST /api/communication-management/announcements/update
    // Route::post('/update', UpdateAnnouncementIntent::class)
    //     ->name('announcements.update');

    // Publish announcement (TODO: Implement PublishAnnouncementIntent)
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
//    ...
//
// 7. Chat Management Routes
//
//    Get Chat Threads:
//    POST /api/communication-management/chats/threads
//    Body: { "page": 1, "per_page": 20 }
//
//    Get Messages:
//    POST /api/communication-management/chats/messages
//    Body: { "chat_group_id": 1, "page": 1, "per_page": 50 }
//
//    Send Message:
//    POST /api/communication-management/chats/send
//    Body: { "chat_group_id": 1, "type": "text|image|file", "content": "Hello", "attachment": File }
//
//    Create Group:
//    POST /api/communication-management/chats/create
//    Body: { "name": "Group Name", "type": "group|direct", "user_ids": [1, 2] }
//
//    Mark Read:
//    POST /api/communication-management/chats/mark-read
//    Body: { "chat_group_id": 1 }

// Chat Management Group - Supports both 'chats' and 'messages' prefixes for compatibility
$chatRoutes = function () {
    Route::post('/threads', GetChatThreadsIntent::class)->name('chats.threads');
    Route::post('/messages', GetChatMessagesIntent::class)->name('chats.messages');
    Route::post('/send', SendChatMessageIntent::class)->name('chats.send');
    Route::post('/messages/update', UpdateChatMessageIntent::class)->name('chats.messages.update');
    Route::post('/messages/delete', DeleteChatMessageIntent::class)->name('chats.messages.delete');
    Route::post('/messages/receipts', GetMessageReadReceiptsIntent::class)->name('chats.messages.receipts');
    Route::post('/messages/react', ToggleChatMessageReactionIntent::class)->name('chats.messages.react');
    Route::post('/create', CreateChatGroupIntent::class)->name('chats.create');
    Route::post('/mark-read', MarkChatAsReadIntent::class)->name('chats.mark-read');
    Route::post('/update-group', UpdateChatGroupIntent::class)->name('chats.update-group');
    Route::post('/add-members', AddChatGroupMembersIntent::class)->name('chats.add-members');
    Route::post('/remove-member', RemoveChatGroupMemberIntent::class)->name('chats.remove-member');
    Route::post('/members', GetChatGroupMembersIntent::class)->name('chats.members');
    Route::post('/media', GetChatGroupMediaIntent::class)->name('chats.media');
    Route::post('/search-users', SearchChatUsersIntent::class)->name('chats.search-users');
    Route::post('/delete-group', DeleteChatGroupIntent::class)->name('chats.delete-group');
    Route::post('/toggle-pin', ToggleChatGroupPinIntent::class)->name('chats.toggle-pin');
    Route::post('/focus', SetChatFocusIntent::class)->name('chats.focus');
    
    // Chunked Media Upload Routes
    Route::prefix('media/uploads')->group(function() {
        Route::post('/init', UploadChatMediaInitIntent::class)->name('chats.media.uploads.init');
        Route::post('/push', UploadChatMediaPushIntent::class)->name('chats.media.uploads.push');
        Route::post('/finish', UploadChatMediaFinishIntent::class)->name('chats.media.uploads.finish');
    });

    // Voice Note Upload (single-request, dedicated — see UploadVoiceNoteAction for why)
    Route::post('/voice-notes/upload', UploadVoiceNoteIntent::class)->name('chats.voice-notes.upload');

    // Per-group "allow voice notes" admin toggle (dedicated, additive — see SetChatGroupVoiceNoteAction)
    Route::post('/set-voicenote', SetChatGroupVoiceNoteIntent::class)->name('chats.set-voicenote');

    // Polls (dedicated, additive — see CreatePollAction and friends)
    Route::prefix('polls')->group(function () {
        Route::post('/create', CreatePollIntent::class)->name('chats.polls.create');
        Route::post('/vote', VotePollIntent::class)->name('chats.polls.vote');
        Route::post('/close', ClosePollIntent::class)->name('chats.polls.close');
        Route::post('/details', GetPollDetailsIntent::class)->name('chats.polls.details');
        Route::post('/voters', GetPollVotersIntent::class)->name('chats.polls.voters');
    });
};

Route::prefix('chats')->middleware(AuthGuard::class)->group($chatRoutes);
Route::prefix('messages')->middleware(AuthGuard::class)->group($chatRoutes);
