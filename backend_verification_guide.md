# Backend Notification Verification Guide

This guide ensures that your backend server, database, and background queues are correctly configured to process push notifications.

## 1. System Health Check

Before testing notifications, verify that your backend can boot without errors.

### 1.1 Check Database Connectivity & Table Existence
Since you manually created the table, verify it is visible to Laravel.

```bash
# Check if Laravel can actually see the 'tenants' table
php artisan tinker --execute="echo DB::connection('pgsql')->getSchemaBuilder()->hasTable('tenants') ? 'YES' : 'NO';"
```

**✅ Success**: Output is `YES`.
**❌ Failure**: Output is `NO` or an error.

**Fix for Failure**:
1. Check your `.env` `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`.
2. Ensure you created the `tenants` table in the database pointed to by `pgsql` connection (Landlord), NOT the tenant database.
3. If using schemas (Postgres), ensure it's in the `public` schema or search path.


### 1.2 Check Logs
Clear the logs and ensure no errors appear on startup.
```bash
truncate -s 0 storage/logs/laravel.log
php artisan about
```

---

## 2. Queue Configuration Verification

Push notifications are processed in the background. If the queue isn't running, notifications will stay in the "Pending" state forever.

### 2.1 Check Queue Connection
Open `.env` and verify:
```env
QUEUE_CONNECTION=database
# OR
QUEUE_CONNECTION=redis
```

### 2.2 Verify Jobs Table (if using database queue)
If using `QUEUE_CONNECTION=database`, run:
```sql
# Run in your database client or tinker:
DB::table('jobs')->count();
```
(It should return a number, likely 0 if empty).

---

## 3. Usage Verification (The Test)

Use the manual test script we created to trigger the entire flow.

### Step 1: Run the Test Script
This creates a notification and **dispatches** the job to the queue.

```bash
php artisan tinker tests/Manual/TestPushNotification.php
```

**Expected Output**:
> "Notification Created ID: 123"
> "Check your logs for 'Starting push notification job'."

### Step 2: Run the Queue Worker
This picks up the job and tries to send it.

```bash
php artisan queue:work --stop-when-empty
```

**Expected Output**:
> [2026-01-23 12:00:00] Processing: App\Jobs\SendPushNotificationJob
> [2026-01-23 12:00:01] Processed:  App\Jobs\SendPushNotificationJob

### Step 3: Check Backend Logs (The Proof)
Since we added debug logs, this is the definitive proof of what happened.

```bash
cat storage/logs/laravel.log | grep "DEBUG: Expo"
```

**Example Success Log**:
```
[2026-01-23 12:00:00] ... DEBUG: Expo Payload {"to":"ExponentPushToken[...]","title":...}
[2026-01-23 12:00:01] ... DEBUG: Expo Response: {"data":[{"status":"ok","id":"..."}]}
```

**Example Failure Log (Expo Rejected)**:
```
[2026-01-23 12:00:01] ... DEBUG: Expo Response: {"errors":[{"code":"PUSH_TOKEN_INVALID",...}]}
```
