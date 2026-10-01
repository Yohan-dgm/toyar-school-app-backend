# Comprehensive Notification System Implementation Guide

This guide covers the complete implementation of a notification system with Laravel backend and React Native (Expo) frontend, featuring push notifications and real-time updates.

## 🎯 Overview

The implemented system provides:
- ✅ **Expo Push Notifications** - Mobile push notifications via Expo's service
- ✅ **Laravel Echo Integration** - Real-time updates via WebSockets/Pusher
- ✅ **Token Management** - Device-specific push token storage and cleanup
- ✅ **Error Handling** - Comprehensive error tracking and retry logic
- ✅ **Background Jobs** - Queue-based processing for reliable delivery
- ✅ **Real-time Broadcasting** - Instant UI updates when notifications arrive
- ✅ **State Management** - Complete React Native notification state management
- ✅ **UI Components** - Ready-to-use notification components

## 🏗️ Architecture Overview

### Backend Components (Laravel)

#### 1. Database Layer
```
user_push_tokens - Store Expo push tokens per user/device
notifications - Enhanced with push notification support
notification_recipients - Track delivery status per user
```

#### 2. Services
- `ExpoPushNotificationService` - Handle Expo API calls and batch processing
- `NotificationService` - Enhanced with push and broadcast capabilities
- `NotificationErrorHandler` - Comprehensive error handling and token management

#### 3. Background Jobs
- `SendPushNotificationJob` - Process push notifications in background
- `CleanupPushTokensJob` - Clean up invalid/expired tokens
- `ProcessScheduledNotificationsJob` - Handle scheduled notifications

#### 4. API Endpoints
```
POST /api/user-management/push-tokens/register - Register push token
POST /api/user-management/push-tokens/delete - Delete push token
POST /api/communication-management/notifications/* - Existing notification APIs
```

#### 5. Broadcasting Events
- `NotificationCreated` - When new notification is sent
- `NotificationRead` - When user reads notification  
- `NotificationStatsUpdated` - When unread counts change

### Frontend Components (React Native + Expo)

#### 1. Services
- `PushNotificationService` - Handle Expo push notifications
- `LaravelEchoService` - WebSocket connection and real-time events

#### 2. State Management
- `useNotifications` hook - Complete notification state management
- Real-time updates and optimistic UI updates

#### 3. UI Components
- `NotificationList` - Full-featured notification list with pagination
- `NotificationItem` - Individual notification display
- `NotificationBadge` - Badge counts for tabs/headers
- `EmptyNotifications` - Empty states

## 📋 Setup Instructions

### Backend Setup

#### 1. Database Setup
```bash
# Run the SQL files to create tables
psql -d your_database -f modules/UserManagement/Database/Sql/user_push_tokens.sql
```

#### 2. Queue Configuration
```bash
# Configure your queue driver in .env
QUEUE_CONNECTION=redis  # or database, sqs, etc.

# Run queue workers
php artisan queue:work --queue=push-urgent,push-high,push-normal,broadcast-urgent,broadcast-high,broadcast-normal
```

#### 3. Broadcasting Setup

For **Pusher**:
```bash
# .env
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-app-key
PUSHER_APP_SECRET=your-app-secret
PUSHER_APP_CLUSTER=your-cluster
```

For **Laravel Reverb**:
```bash
# Install and configure Reverb
composer require laravel/reverb
php artisan install:broadcasting

# .env
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=your-app-id
REVERB_APP_KEY=your-app-key
REVERB_APP_SECRET=your-app-secret
REVERB_HOST=localhost
REVERB_PORT=8080
```

#### 4. Scheduled Tasks
```bash
# Add to your cron
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```

### Frontend Setup

#### 1. Install Dependencies
```bash
npm install expo-notifications expo-device @react-native-async-storage/async-storage
npm install laravel-echo pusher-js
npm install react-native-gesture-handler  # For swipe actions
```

#### 2. Configure Expo
```javascript
// app.json
{
  "expo": {
    "notification": {
      "icon": "./assets/notification-icon.png",
      "color": "#000000"
    }
  }
}
```

#### 3. Initialize Services
```javascript
// App.js
import PushNotificationService from './services/PushNotificationService';
import LaravelEchoService from './services/LaravelEchoService';

export default function App() {
  useEffect(() => {
    const initializeServices = async () => {
      // Initialize after user authentication
      await PushNotificationService.initialize();
      await LaravelEchoService.initialize({
        pusherKey: 'your-pusher-key',
        pusherCluster: 'mt1'
      });
    };

    initializeServices();
  }, []);

  // ... rest of your app
}
```

## 🚀 Usage Examples

### Backend Usage

#### Creating a Notification with Push and Broadcast
```php
use Modules\CommunicationManagement\Services\NotificationService;

$notificationService = new NotificationService();

$notification = $notificationService->sendNotification([
    'notification_type_id' => 1,
    'title' => 'Welcome!',
    'message' => 'Thanks for joining our app.',
    'priority' => 'high',
    'target_type' => 'user',
    'target_data' => ['user_ids' => [1, 2, 3]],
    'created_by' => auth()->id(),
]);

// This automatically:
// 1. Stores notification in database
// 2. Broadcasts real-time events to users
// 3. Dispatches push notification job
```

#### Manual Push Token Management
```php
use Modules\UserManagement\Models\UserPushToken;

// Register token
$token = UserPushToken::createOrUpdateToken(
    userId: 1,
    deviceId: 'device-123',
    pushToken: 'ExponentPushToken[xxxxx]',
    platform: 'ios',
    deviceInfo: [
        'app_version' => '1.0.0',
        'device_name' => 'iPhone 14 Pro'
    ]
);

// Clean up invalid tokens
$cleaned = UserPushToken::cleanupInvalidTokens();
```

### Frontend Usage

#### Using the Notification Hook
```javascript
import { useNotifications } from './hooks/useNotifications';

function NotificationScreen() {
  const {
    notifications,
    unreadCount,
    isLoading,
    markAsRead,
    markAllAsRead,
    refreshNotifications
  } = useNotifications();

  useEffect(() => {
    // Initialize the notification system
    initialize();
  }, []);

  return (
    <NotificationList
      filter="all"
      onNotificationPress={(notification) => {
        // Handle notification tap
        console.log('Tapped:', notification);
        
        // Navigate if needed
        if (notification.actionUrl) {
          // Navigate to the URL
        }
      }}
    />
  );
}
```

#### Custom Badge Usage
```javascript
import NotificationBadge from './components/NotificationBadge';

function TabBar() {
  const { unreadCount, urgentCount } = useNotifications();

  return (
    <TouchableOpacity style={{ position: 'relative' }}>
      <Icon name="notifications" size={24} />
      <NotificationBadge 
        count={unreadCount}
        size="small"
        color={urgentCount > 0 ? '#FF3B30' : '#007AFF'}
      />
    </TouchableOpacity>
  );
}
```

## 🔧 Monitoring and Maintenance

### Error Monitoring
```php
use App\Services\NotificationErrorHandler;

// Get error statistics
$errorStats = NotificationErrorHandler::getErrorStats(7); // Last 7 days

// Generate comprehensive report
$report = NotificationErrorHandler::generateErrorReport();
echo $report;
```

### Token Health Monitoring
```php
use Modules\CommunicationManagement\Services\ExpoPushNotificationService;

$pushService = new ExpoPushNotificationService();
$stats = $pushService->getPushStats();

// Monitor health percentage
if ($stats['health_percentage'] < 80) {
    // Alert administrators
}
```

### Manual Cleanup Commands
```bash
# Clean up push tokens (dry run first)
php artisan push-tokens:cleanup --dry-run
php artisan push-tokens:cleanup

# Process scheduled notifications
php artisan notifications:process-scheduled

# Check queue status
php artisan queue:monitor
```

## 🛡️ Best Practices

### Security
- ✅ All API endpoints require authentication
- ✅ Private channels for user-specific notifications
- ✅ Token validation and cleanup
- ✅ Rate limiting on notification creation

### Performance
- ✅ Background job processing for push notifications
- ✅ Batch processing for multiple recipients
- ✅ Database indexing for fast queries
- ✅ Optimistic updates in React Native

### Reliability
- ✅ Retry logic for failed push notifications
- ✅ Error tracking and token cleanup
- ✅ Automatic reconnection for WebSocket
- ✅ Graceful fallback handling

### User Experience
- ✅ Real-time UI updates
- ✅ Offline state handling
- ✅ Pull-to-refresh functionality
- ✅ Swipe actions for quick operations

## 🐛 Troubleshooting

### Common Issues

**Push notifications not working:**
1. Check if tokens are registered: `POST /api/user-management/push-tokens/register`
2. Verify Expo configuration in app.json
3. Check background job processing: `php artisan queue:work`
4. Review error logs: `NotificationErrorHandler::getErrorStats()`

**Real-time updates not working:**
1. Verify broadcasting configuration (Pusher/Reverb)
2. Check WebSocket connection status
3. Ensure private channel authentication is working
4. Test with: `php artisan tinker` and `broadcast(new NotificationCreated(...))`

**High error rates:**
1. Run cleanup command: `php artisan push-tokens:cleanup`
2. Check error statistics: `NotificationErrorHandler::generateErrorReport()`
3. Review token health: `ExpoPushNotificationService::getPushStats()`

## 📊 Metrics and Analytics

The system provides comprehensive metrics:

- **Push Token Health**: Active tokens, failure rates, platform distribution
- **Notification Delivery**: Success rates, delivery times, read rates
- **Error Tracking**: Common errors, affected users, platform-specific issues
- **Real-time Performance**: Connection stability, broadcast success rates

Monitor these metrics regularly to maintain optimal performance and user experience.

## 🎉 Conclusion

This comprehensive notification system provides a robust, scalable solution for mobile notifications with both push notifications and real-time updates. The system handles error scenarios gracefully and provides extensive monitoring capabilities to ensure reliable operation.

The modular architecture makes it easy to extend and customize based on your specific requirements, while the comprehensive error handling ensures optimal user experience even when issues occur.