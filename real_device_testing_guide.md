# Real Device Push Notification Testing (Expo)

This guide explains how to test push notifications on a physical device using the Expo Go app.

## Prerequisites

1.  **Mobile Device**: An Android or iOS device.
2.  **Expo Go App**: Installed from the Google Play Store or Apple App Store.
3.  **Expo Account**: You must be logged in to Expo CLI (`npx expo login`) and the Expo Go app with the same account (or use a development build).
4.  **Backend Network**: Your mobile device must be able to reach your backend API.
    - If running locally, ensure your backend is on a shared network (e.g., WiFi) and configured to listen on `0.0.0.0` or your LAN IP, NOT just `localhost`.
    - Update `.env`: `APP_URL=http://<YOUR_LAN_IP>:8000`

## Step 1: Register Push Token (Frontend)

1.  Start your frontend application:
    ```bash
    npx expo start
    ```
2.  Scan the QR code with your mobile device to open the app in Expo Go.
3.  **Login** to the app (or perform the action that triggers token registration).
    - The app should automatically ask for notification permissions. **Allow** them.
    - Upon permission grant, the app generates an `ExponentPushToken[...]` and sends it to your backend API.

## Step 2: Verify Token in Backend

1.  Check your database to ensure the token was saved.
    ```sql
    SELECT * FROM user_push_tokens WHERE user_id = <YOUR_USER_ID>;
    ```
2.  Status verification:
    - `is_active` should be `true`.
    - `push_token` should look like `ExponentPushToken[xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx]`.

## Step 3: Trigger Test Notification

You can use the backend test script created earlier, but execute it with your **real user ID** (the one logged in on the device).

1.  Edit `tests/Manual/TestPushNotification.php`:
    - Comment out the "Dummy Push Token" creation part (Step 2 in the script), because we want to use the *real* token already in the database.
    - **OR**, just modify the payload target:
    ```php
    // tests/Manual/TestPushNotification.php

    // ... (Use the User ID you logged in with)
    $user = User::find(<YOUR_REAL_USER_ID>); 

    // Skip creating a new token if one exists in DB
    // $userToken = UserPushToken::createOrUpdateToken(...); 

    // Create Notification
    $payload = [
        // ...
        'target_data' => ['user_id' => $user->id],
        // ...
    ];
    ```

2.  Run the script:
    ```bash
    php artisan tinker tests/Manual/TestPushNotification.php
    ```

3.  Run the queue worker:
    ```bash
    php artisan queue:work
    ```

## Step 4: Verify Delivery

1.  **On Device**: Check if the notification banner appears.
    - *Note*: On iOS/Android, notifications might not show a banner if the app is currently **open** (foreground). Background the app (go to home screen) to see the banner.
2.  **Expo Diagnostics**:
    - If not received, go to [Expo Push Notification Tool](https://expo.dev/notifications)
    - Enter the token from Step 2.
    - Send a test message.
    - If this fails, the issue is between Expo and your Device (permissions, network).
    - If this works, the issue is in your Backend <-> Expo connection.

## Troubleshooting

-   **"ExperienceId does not match"**: Ensure your `app.json` slug matches the project ID in your backend `.env` (`EXPO_PROJECT_ID`).
-   **Local Network Issues**: If the app can't register the token, it might be unable to reach your local backend API. Ensure firewall rules allow port 8000 (or whichever port you use) access from other devices.
