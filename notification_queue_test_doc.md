# Notification Queue & Push Notification Testing Guide

This document outlines how to manually test the server-side queue process for sending push notifications in the Toyar School App backend.

## Prerequisites

1.  **Database Connection**: Ensure your `.env` is configured with a valid database connection.
    - If using multi-tenancy, verify `landlord` and `tenant` connections.
2.  **Queue Driver**: Ensure `QUEUE_CONNECTION` is set to `database` or `redis` in `.env`.
    ```env
    QUEUE_CONNECTION=database
    ```
    - If using `database`, ensure the `jobs` table exists (`php artisan queue:table` && `php artisan migrate`).
3.  **Push Service**: Ensure Expo credentials are set in `.env`:
    ```env
    PUSH_SERVICE=expo
    EXPO_ACCESS_TOKEN=your_token
    ```

## Manual Test Script

A manual test script has been created at `tests/Manual/TestPushNotification.php`. This script:
1.  Selects the first user from the database.
2.  Assigns a valid dummy Expo push token to that user.
3.  Triggers a Notification creation (which dispatches a queue job).

### How to Run

1.  Open your terminal in the project root.
2.  Execute the script using Laravel Tinker:
    ```bash
    php artisan tinker tests/Manual/TestPushNotification.php
    ```

### Expected Output

You should see output indicating the user ID, token creation, and notification ID:
```text
Using User ID: 1 (System Admin)
Push Token Created/Updated: ExponentPushToken[xxxxxxxxxxxxxxxxxxxxxx]
Creating Notification...
Notification Created ID: 152
Check your logs for 'Starting push notification job'.
Run 'php artisan queue:work' to process the job if not running.
```

## Processing the Queue

After running the script, the job is pushed to the queue. You must run the worker to process it.

1.  Run the queue worker:
    ```bash
    php artisan queue:work
    ```
    Or for a specific queue (e.g., if priority was urgent):
    ```bash
    php artisan queue:work --queue=push-urgent,default
    ```

2.  Observe the output:
    ```text
    [2025-01-22 12:00:00] Processing: App\Jobs\SendPushNotificationJob
    [2025-01-22 12:00:02] Processed:  App\Jobs\SendPushNotificationJob
    ```

## Verifying Logs

Check `storage/logs/laravel.log` for detailed execution logs:

```bash
tail -n 50 storage/logs/laravel.log
```

**Success Logs:**
- `Starting push notification job`
- `Push notification job completed`

**Failure Logs:**
- `Expo push notification failed` (This is expected if using a fake token, but confirms the job ran).
