# 🧪 Notification Push Testing Guide with Postman

## 📋 Overview

This guide provides step-by-step instructions for testing the complete notification creation and push notification delivery flow using Postman. It covers the entire process from authentication to verifying push notification delivery.

## 🔧 Prerequisites & Setup

### Backend Requirements
- Laravel backend running on `http://172.16.20.183:9999`
- PostgreSQL database with notification tables
- Queue worker running: `php artisan queue:listen`
- Laravel Reverb WebSocket server running: `php artisan reverb:start`

### Postman Setup
1. Import the provided Postman collection: `NOTIFICATION_POSTMAN_COLLECTION.json`
2. Set up environment variables in Postman:
   - `base_url`: `http://172.16.20.183:9999`
   - `auth_token`: (will be set automatically after sign-in)
   - `user_id`: (will be set automatically after sign-in)
   - `notification_id`: (will be set automatically after creating notification)

### Verification Commands

```bash
# Check if queue worker is running
ps aux | grep "queue:listen"

# Check if Reverb server is running
ps aux | grep "reverb"

# Check database connection
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "SELECT 1;"
```

## 🚀 Complete Testing Flow

### Step 1: Authentication

**Postman Request:** `Authentication > User Sign In`

**Request Details:**
```http
POST {{base_url}}/api/user-management/user/sign-in
Content-Type: application/json

{
  "email": "testuser@nexiscollege.lk",
  "password": "password"
}
```

**Expected Response:**
```json
{
  "success": true,
  "message": "Sign in successful",
  "data": {
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
      "id": 45,
      "name": "Test User",
      "email": "testuser@nexiscollege.lk"
    }
  }
}
```

**Verification:**
- ✅ Response status: 200
- ✅ Token is present in response
- ✅ Environment variables `auth_token` and `user_id` are set automatically

### Step 2: Register Push Token

**Postman Request:** `Push Token Management > Register Push Token`

**Request Details:**
```http
POST {{base_url}}/api/user-management/push-tokens/register
Content-Type: application/json
Authorization: Bearer {{auth_token}}

{
  "push_token": "ExponentPushToken[xxxxxxxxxxxxxxxxxxxxxx]",
  "device_id": "test_device_postman_{{$randomInt}}",
  "platform": "ios",
  "app_version": "1.0.0",
  "device_name": "Test iPhone",
  "device_model": "iPhone 14 Pro",
  "os_version": "16.0"
}
```

**Expected Response:**
```json
{
  "success": true,
  "message": "Push token registered successfully",
  "data": {
    "id": 123,
    "user_id": 45,
    "device_id": "test_device_postman_123",
    "platform": "ios",
    "is_active": true,
    "was_updated": false,
    "created_at": "2025-01-15T10:30:00.000000Z",
    "updated_at": "2025-01-15T10:30:00.000000Z"
  }
}
```

**Database Verification:**
```sql
-- Check push token in database
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "
SELECT id, user_id, device_id, platform, is_active, created_at 
FROM user_push_tokens 
WHERE user_id = 45 
ORDER BY created_at DESC 
LIMIT 5;
"
```

### Step 3: Create Test Notification

**Postman Request:** `Notification Management > Create Notification (Admin)`

**Request Details:**
```http
POST {{base_url}}/api/communication-management/notifications/create
Content-Type: application/json
Authorization: Bearer {{auth_token}}

{
  "notification_type_id": 1,
  "title": "🔔 Push Notification Test",
  "message": "This is a test notification to verify that push notifications are working correctly. You should receive this on your mobile device if push tokens are properly configured.",
  "priority": "high",
  "target_type": "user",
  "target_data": {
    "user_ids": [{{user_id}}]
  },
  "action_url": "/test/notification",
  "action_text": "View Details"
}
```

**Expected Response:**
```json
{
  "success": true,
  "message": "Notification created successfully",
  "data": {
    "id": 456,
    "title": "🔔 Push Notification Test",
    "message": "This is a test notification to verify...",
    "priority": "high",
    "target_type": "user",
    "target_data": {
      "user_ids": [45]
    },
    "is_active": true,
    "sent_at": "2025-01-15T10:35:00.000000Z",
    "created_at": "2025-01-15T10:35:00.000000Z"
  }
}
```

**Immediate Verification Steps:**

1. **Check Notification in Database:**
```sql
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "
SELECT id, title, message, priority, target_type, is_active, sent_at, created_at 
FROM notifications 
WHERE id = 456;
"
```

2. **Check Notification Recipients:**
```sql
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "
SELECT id, notification_id, user_id, is_delivered, delivered_at, push_sent, push_sent_at, push_attempts 
FROM notification_recipients 
WHERE notification_id = 456;
"
```

3. **Check Queue Jobs:**
```sql
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "
SELECT id, queue, payload, created_at 
FROM jobs 
ORDER BY created_at DESC 
LIMIT 5;
"
```

### Step 4: Monitor Queue Processing

**Check Queue Worker Output:**
```bash
# If running queue worker in foreground, you should see:
[2025-01-15 10:35:01][123] Processing: App\Jobs\SendPushNotificationJob
[2025-01-15 10:35:02][123] Processed:  App\Jobs\SendPushNotificationJob
```

**Check Failed Jobs:**
```sql
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "
SELECT id, queue, payload, failed_at, exception 
FROM failed_jobs 
ORDER BY failed_at DESC 
LIMIT 3;
"
```

### Step 5: Verify Push Notification Processing

**Check Push Token Status After Processing:**
```sql
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "
SELECT id, user_id, device_id, is_active, failure_count, failure_reason, last_used_at 
FROM user_push_tokens 
WHERE user_id = 45;
"
```

**Check Notification Recipient Push Status:**
```sql
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "
SELECT nr.id, nr.notification_id, nr.user_id, nr.push_sent, nr.push_sent_at, 
       nr.push_attempts, nr.push_error, n.title 
FROM notification_recipients nr 
JOIN notifications n ON nr.notification_id = n.id 
WHERE nr.notification_id = 456;
"
```

**Expected Results:**
- `push_sent` should be `true` if push was successful
- `push_sent_at` should have a timestamp
- `push_attempts` should be 1 (or higher if retries occurred)
- `push_error` should be `null` if successful

### Step 6: Test Different Notification Types

#### A. Broadcast Notification

**Postman Request:** `Advanced Notification Tests > Create Broadcast Notification`

```http
POST {{base_url}}/api/communication-management/notifications/create
Authorization: Bearer {{auth_token}}

{
  "notification_type_id": 1,
  "title": "📢 School Announcement",
  "message": "Important school-wide announcement: All classes are cancelled tomorrow due to weather conditions.",
  "priority": "urgent",
  "target_type": "broadcast",
  "action_url": "/announcements/weather-alert",
  "action_text": "Read Full Notice"
}
```

#### B. High Priority Notification

**Request:**
```http
POST {{base_url}}/api/communication-management/notifications/create
Authorization: Bearer {{auth_token}}

{
  "notification_type_id": 1,
  "title": "🚨 Urgent: Emergency Drill",
  "message": "Emergency drill starting in 5 minutes. Please proceed to designated assembly areas.",
  "priority": "urgent",
  "target_type": "user",
  "target_data": {
    "user_ids": [{{user_id}}]
  }
}
```

#### C. Scheduled Notification

**Request:**
```http
POST {{base_url}}/api/communication-management/notifications/create
Authorization: Bearer {{auth_token}}

{
  "notification_type_id": 1,
  "title": "📅 Reminder: Parent Meeting Tomorrow",
  "message": "Don't forget about the parent-teacher meeting scheduled for tomorrow at 3 PM.",
  "priority": "normal",
  "target_type": "user",
  "target_data": {
    "user_ids": [{{user_id}}]
  },
  "is_scheduled": true,
  "scheduled_at": "2025-01-16T08:00:00Z"
}
```

### Step 7: Real-time WebSocket Testing

**Setup WebSocket Connection:**
```javascript
// Test WebSocket connection (if you have a WebSocket client)
const echo = new Echo({
  broadcaster: 'reverb',
  key: 'ftlvjzbndng2pip2xruw',
  wsHost: '172.16.20.183',
  wsPort: 8080,
  forceTLS: false,
  auth: {
    headers: {
      Authorization: `Bearer YOUR_JWT_TOKEN`,
      Accept: 'application/json',
    },
  },
});

// Subscribe to user notification channel
echo.private(`user.45.notifications`)
  .listen('notification.created', (data) => {
    console.log('New notification received:', data);
  })
  .listen('notification.read', (data) => {
    console.log('Notification read:', data);
  });
```

**Expected WebSocket Events:**
When you create a notification, you should receive:

```json
{
  "id": 456,
  "recipient_id": 789,
  "title": "🔔 Push Notification Test",
  "message": "This is a test notification...",
  "priority": "high",
  "priority_label": "High Priority",
  "priority_color": "#ff8800",
  "type": "general",
  "type_name": "General",
  "is_read": false,
  "created_at": "2025-01-15T10:35:00.000000Z",
  "time_ago": "just now"
}
```

## 🔍 Verification Checklist

After creating a notification, verify the following:

### ✅ Database Verification
- [ ] Notification record created in `notifications` table
- [ ] Recipient record created in `notification_recipients` table
- [ ] Notification marked as `sent_at` with timestamp
- [ ] Recipient marked as `is_delivered = true`

### ✅ Queue Processing Verification
- [ ] `SendPushNotificationJob` was queued
- [ ] Job was processed successfully (no failed jobs)
- [ ] Queue worker logs show processing

### ✅ Push Notification Verification
- [ ] `push_sent = true` in notification_recipients table
- [ ] `push_sent_at` has timestamp
- [ ] `push_attempts >= 1`
- [ ] No `push_error` (should be null for success)
- [ ] Push token remains `is_active = true`

### ✅ Real-time Verification
- [ ] WebSocket event `notification.created` broadcasted
- [ ] Event contains correct notification data
- [ ] User stats updated event sent

## 🚨 Troubleshooting Common Issues

### Issue 1: Queue Jobs Not Processing

**Symptoms:**
- Jobs remain in `jobs` table
- No queue worker output
- Push notifications not sent

**Solutions:**
```bash
# Check if queue worker is running
ps aux | grep queue

# Start queue worker if not running
php artisan queue:listen --tries=1

# Check for failed jobs
php artisan queue:failed

# Clear failed jobs if needed
php artisan queue:flush
```

### Issue 2: Push Notifications Not Sent

**Check Push Token Status:**
```sql
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "
SELECT id, device_id, is_active, failure_count, failure_reason 
FROM user_push_tokens 
WHERE user_id = 45;
"
```

**Common Issues:**
- Invalid push token format
- Push token marked as inactive
- Network connection issues to Expo API

**Solutions:**
- Re-register push token
- Check network connectivity
- Verify push token format

### Issue 3: Authentication Errors

**Symptoms:**
- 401 Unauthorized responses
- "Token missing or invalid" messages

**Solutions:**
```bash
# Check if token is set in Postman environment
echo {{auth_token}}

# Re-authenticate if token expired
# Use: Authentication > User Sign In request
```

### Issue 4: Database Connection Issues

**Check Database:**
```bash
PGPASSWORD=1234 psql -h 127.0.0.1 -U macbookair -d school_app -c "SELECT NOW();"
```

**Check Laravel Database Connection:**
```bash
php artisan tinker --execute="DB::select('SELECT 1');"
```

## 📊 Expected Results Summary

### Successful Notification Flow

1. **API Response:** `success: true` with notification ID
2. **Database:** Records created in notifications and notification_recipients tables
3. **Queue:** Job processed successfully
4. **Push Status:** `push_sent: true` in database
5. **Real-time:** WebSocket event broadcasted
6. **Logs:** No errors in Laravel logs

### Performance Benchmarks

- **Notification Creation:** < 500ms
- **Queue Processing:** < 5 seconds
- **Push Delivery:** < 10 seconds
- **WebSocket Broadcast:** < 1 second

## 📝 Test Log Template

Use this template to document your testing results:

```
=== NOTIFICATION PUSH TEST LOG ===
Date: 2025-01-15
Time: 10:30 AM
Tester: [Your Name]

SETUP:
✅ Backend running on http://172.16.20.183:9999
✅ Queue worker active
✅ Reverb WebSocket server running
✅ Database accessible

TEST RESULTS:

1. Authentication:
   - Status: ✅ SUCCESS / ❌ FAILED
   - Token received: [Yes/No]
   - User ID: [45]

2. Push Token Registration:
   - Status: ✅ SUCCESS / ❌ FAILED
   - Token ID: [123]
   - Device ID: [test_device_postman_456]

3. Notification Creation:
   - Status: ✅ SUCCESS / ❌ FAILED
   - Notification ID: [456]
   - Database record: [Yes/No]

4. Queue Processing:
   - Status: ✅ SUCCESS / ❌ FAILED
   - Processing time: [3 seconds]
   - Failed jobs: [0]

5. Push Notification:
   - Status: ✅ SUCCESS / ❌ FAILED
   - push_sent: [true]
   - push_sent_at: [2025-01-15 10:35:00]

6. Real-time Events:
   - Status: ✅ SUCCESS / ❌ FAILED / ⚠️ NOT TESTED
   - Event received: [Yes/No]

ISSUES ENCOUNTERED:
- [List any issues and solutions]

OVERALL RESULT: ✅ SUCCESS / ⚠️ PARTIAL / ❌ FAILED
```

## 🎯 Advanced Testing Scenarios

### Scenario 1: High Volume Testing

Create multiple notifications rapidly to test queue processing:

```bash
# Use Postman Runner or Collection Runner
# Set iterations: 10
# Delay: 1000ms between requests
```

### Scenario 2: Error Handling Testing

Test with invalid push tokens:

```json
{
  "push_token": "INVALID_TOKEN_FORMAT",
  "device_id": "test_invalid",
  "platform": "ios"
}
```

### Scenario 3: Priority Testing

Create notifications with different priorities and verify queue processing order:

1. Create urgent notification
2. Create normal notification
3. Create high notification
4. Verify processing order matches priority

## 📞 Support & Next Steps

If you encounter issues:

1. **Check Laravel Logs:** `storage/logs/laravel.log`
2. **Check Queue Logs:** Queue worker output
3. **Verify Database:** Use provided SQL queries
4. **Test with Postman:** Use the provided collection

**Contact:** Development team for backend issues, frontend team for mobile integration.

This comprehensive testing guide ensures you can thoroughly verify the notification and push notification system is working correctly end-to-end.