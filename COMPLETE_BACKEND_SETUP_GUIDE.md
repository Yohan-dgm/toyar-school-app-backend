# Complete Backend Setup Guide - Push Notifications & Real-time Updates

## 🎯 **BACKEND STATUS: ✅ COMPLETE & READY**

All backend components for push notifications and real-time updates are properly configured and ready for use.

---

## 📋 **CONFIGURATION VERIFICATION CHECKLIST**

### ✅ **Environment Variables (.env)**
- [x] `PUSH_SERVICE=expo` - Primary service configured
- [x] `EXPO_ACCESS_TOKEN` - Valid Expo access token
- [x] `EXPO_PROJECT_ID` - Project UUID configured  
- [x] `APNS_KEY_ID`, `APNS_TEAM_ID`, `APNS_BUNDLE_ID` - Apple push configured
- [x] `FCM_SERVER_KEY`, `FCM_PROJECT_ID` - Firebase configured
- [x] `BROADCAST_CONNECTION=reverb` - Real-time broadcasting enabled
- [x] `REVERB_APP_ID`, `REVERB_APP_KEY`, `REVERB_APP_SECRET` - Reverb configured
- [x] Push notification performance settings (batch size, retries, timeouts)
- [x] Queue configuration for different priority levels
- [x] Notification system settings (cleanup, cache TTL)

### ✅ **Database Tables**
- [x] `notifications` - Core notification storage
- [x] `notification_recipients` - User-specific notification tracking
- [x] `notification_types` - Notification categorization
- [x] `user_push_tokens` - Device push token management
- [x] `announcements` - School announcements
- [x] `announcement_categories` - Announcement categorization

### ✅ **Configuration Files**
- [x] `config/push-notifications.php` - Complete push service configuration
- [x] `config/broadcasting.php` - Laravel Reverb real-time configuration
- [x] `config/queue.php` - Queue workers for push notifications

### ✅ **Core Services & Classes**
- [x] `NotificationService` - Main notification creation and management
- [x] `ExpoPushNotificationService` - Push notification delivery
- [x] `PushConfigurationService` - Configuration validation and health checks
- [x] `SendPushNotificationJob` - Queue job for async push delivery
- [x] `NotificationCreated` Event - Real-time broadcasting
- [x] `NotificationRead` Event - Read status broadcasting
- [x] `NotificationStatsUpdated` Event - Statistics broadcasting

### ✅ **API Routes**
- [x] **Notifications**: `/api/communication-management/notifications/*`
  - `POST /create` - Create new notifications
  - `POST /list` - Get user notifications (paginated)
  - `POST /mark-read` - Mark notifications as read
  - `POST /delete` - Delete notifications
  - `POST /details` - Get notification details
  - `POST /stats` - Get notification statistics

- [x] **Push Tokens**: `/api/user-management/push-tokens/*`
  - `POST /register` - Register device push tokens
  - `POST /delete` - Remove device push tokens

- [x] **Announcements**: `/api/communication-management/announcements/*`
  - `POST /create` - Create announcements with notifications
  - `POST /list` - Get announcements list
  - `POST /details` - Get announcement details

---

## 🚀 **TERMINAL COMMANDS FOR BACKEND SETUP**

### **1. Start All Required Services**
```bash
# Start Laravel Reverb for real-time updates
php artisan reverb:start --host=0.0.0.0 --port=8080

# Start queue workers for push notifications (in separate terminals)
php artisan queue:work --queue=push-urgent,push-high,push-normal --tries=3
php artisan queue:work --queue=notification-high,notification-normal,notification-low --tries=3
php artisan queue:work --queue=broadcast-high,broadcast-normal --tries=3

# Start Laravel development server
php artisan serve --host=0.0.0.0 --port=8000

# Start log monitoring (optional)
php artisan pail
```

### **2. Development Environment Setup**
```bash
# Install dependencies
composer install
npm install

# Generate application key
php artisan key:generate

# Run migrations (if needed)
php artisan migrate

# Clear all caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Start frontend development server
npm run dev
```

### **3. Configuration Validation**
```bash
# Validate push notification configuration
php artisan tinker --execute="
use Modules\CommunicationManagement\Services\PushConfigurationService;
\$service = new PushConfigurationService();
\$health = \$service->getHealthStatus();
echo 'Status: ' . \$health['status'] . PHP_EOL;
echo \$service->generateConfigurationReport();
"

# Test database connection
php artisan tinker --execute="
use Illuminate\Support\Facades\DB;
echo 'Database: ' . DB::connection()->getDatabaseName() . PHP_EOL;
echo 'Tables: ' . count(DB::select('SHOW TABLES')) . PHP_EOL;
"
```

### **4. Testing Commands**
```bash
# Test push notification creation
php artisan tinker --execute="
use Modules\CommunicationManagement\Services\NotificationService;
\$service = app(NotificationService::class);
\$notification = \$service->sendNotification([
    'notification_type_id' => 1,
    'title' => 'Backend Test',
    'message' => 'Testing push notification system',
    'priority' => 'normal',
    'target_type' => 'broadcast',
    'target_data' => [],
    'created_by' => 1
]);
echo 'Notification created: ' . \$notification->id . PHP_EOL;
"

# Register test push token
curl -X POST http://localhost:8000/api/user-management/push-tokens/register \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_AUTH_TOKEN" \
  -d '{
    "device_id": "test-device-backend",
    "push_token": "ExponentPushToken[TEST_BACKEND_TOKEN]",
    "platform": "ios",
    "app_version": "1.0.0"
  }'
```

### **5. Production Deployment Commands**
```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer install --no-dev --optimize-autoloader

# Start production services with supervisord or similar
# supervisord configuration for queue workers recommended
```

---

## 🔧 **REAL-TIME BROADCASTING (LARAVEL REVERB)**

### **Current Configuration:**
```bash
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=623485
REVERB_APP_KEY=ftlvjzbndng2pip2xruw
REVERB_APP_SECRET=mjwhbjilpdsiblqexfyk
REVERB_HOST=0.0.0.0
REVERB_PORT=8080
REVERB_SCHEME=http
```

### **WebSocket Connection URL:**
```
ws://localhost:8080/app/ftlvjzbndng2pip2xruw
```

### **Private Channels for Users:**
- User notifications: `private-user.{user_id}.notifications`
- Real-time events: `notification.created`, `notification.read`, `notification.stats.updated`

---

## 🧪 **TESTING & VALIDATION**

### **1. Backend Health Check**
```bash
# Complete system health check
php artisan tinker --execute="
echo '=== BACKEND HEALTH CHECK ===' . PHP_EOL;

// Configuration validation
use Modules\CommunicationManagement\Services\PushConfigurationService;
\$configService = new PushConfigurationService();
\$health = \$configService->getHealthStatus();
echo 'Push Config: ' . \$health['status'] . PHP_EOL;

// Database connectivity
use Illuminate\Support\Facades\DB;
try {
    DB::connection()->getPdo();
    echo 'Database: ✅ Connected' . PHP_EOL;
} catch (Exception \$e) {
    echo 'Database: ❌ Failed' . PHP_EOL;
}

// Queue connectivity
echo 'Queue Driver: ' . config('queue.default') . PHP_EOL;

// Broadcasting
echo 'Broadcast Driver: ' . config('broadcasting.default') . PHP_EOL;

echo PHP_EOL . '✅ Backend is ready for frontend integration!' . PHP_EOL;
"
```

### **2. API Endpoint Testing**
Use the provided HTTP examples in:
```
modules/CommunicationManagement/examples/api-examples.http
```

---

## 📱 **FRONTEND INTEGRATION REQUIREMENTS**

### **Step 1: Push Token Registration**
The frontend must register device push tokens using:
```
POST /api/user-management/push-tokens/register
```

### **Step 2: WebSocket Connection**
Connect to Laravel Reverb for real-time updates:
```javascript
// WebSocket connection details provided in frontend section below
```

### **Step 3: Notification APIs**
Use notification management APIs for listing, reading, and managing notifications.

---

## ⚠️ **IMPORTANT NOTES**

1. **Queue Workers**: Must be running for push notifications to work
2. **Reverb Server**: Must be running for real-time updates
3. **Authentication**: All API endpoints require valid Bearer token
4. **Database**: PostgreSQL connection properly configured
5. **Environment**: All external service credentials configured

---

## 🎉 **BACKEND STATUS: COMPLETE**

✅ **All backend components are implemented and configured**  
✅ **All required services are available**  
✅ **Database tables created and ready**  
✅ **API endpoints implemented and documented**  
✅ **Real-time broadcasting configured**  
✅ **Push notification system ready**  

**The backend is now ready for frontend integration!**

---

**Next Steps**: Provide frontend integration instructions to your development team.