# Real-Time Push Notifications Setup Requirements

This document outlines all the external services, API keys, and configurations you need to obtain and configure on your side to enable push notifications and real-time updates.

## 🚀 **QUICK START CHECKLIST**

-   [ ] Set up Expo account and project
-   [ ] Configure Firebase project for Android push notifications
-   [ ] Set up Apple Developer account for iOS push notifications
-   [ ] Configure Laravel Reverb for real-time updates
-   [ ] Update environment variables
-   [ ] Test push notification delivery

---

## 📱 **1. EXPO PUSH NOTIFICATIONS (Primary Service)**

### What is Expo?

Expo provides a unified push notification service that works across iOS and Android platforms. It's the **recommended primary service** for this application.

### Required Setup Steps:

#### 1.1 Create Expo Account

1. Go to [https://expo.dev/](https://expo.dev/)
2. Sign up for a free account
3. Install Expo CLI: `npm install -g @expo/cli`

#### 1.2 Create Expo Project

```bash
# Create new project (if you don't have one)
expo init YourSchoolApp
cd YourSchoolApp

# Or link existing project
expo login
expo install expo-notifications
```

#### 1.3 Get Expo Access Token

1. Go to [https://expo.dev/accounts/[username]/settings/access-tokens](https://expo.dev/accounts/[username]/settings/access-tokens)
2. Click "Create Token"
3. Give it a name like "School App Backend"
4. Copy the token

#### 1.4 Get Project ID

1. In your project directory: `expo whoami`
2. Run: `expo config` to see your project ID
3. Or find it in `app.json` under `expo.slug`

### Environment Variables Required:

```bash
EXPO_ACCESS_TOKEN=4Blxfiy_YWN_0FvQGTZpU3mRm6B9aC_n2vD4X5ZQ
EXPO_PROJECT_ID=c497b33a-59ce-4ea9-ae5a-ca16190babdd
```

### Test Token Format:

```
ExponentPushToken[xxxxxxxxxxxxxxxxxxxxxx]
```

---

## 🔥 **2. FIREBASE CLOUD MESSAGING (FCM) - Android Push**

### What is FCM?

Firebase Cloud Messaging is Google's solution for sending push notifications to Android devices. It's **optional** if you're using Expo, but provides more control.

### Required Setup Steps:

#### 2.1 Create Firebase Project

1. Go to [https://console.firebase.google.com/](https://console.firebase.google.com/)
2. Click "Create a project"
3. Follow the setup wizard
4. Enable "Cloud Messaging" in the project

#### 2.2 Get Server Key

1. In Firebase Console → Project Settings → Cloud Messaging
2. Copy the "Server key" (Legacy server key)
3. Copy the "Sender ID"

#### 2.3 Generate Service Account Key

1. Go to Project Settings → Service Accounts
2. Click "Generate new private key"
3. Download the JSON file
4. Extract the required fields (see below)

### Environment Variables Required:

```bash
FCM_SERVER_KEY=your_fcm_server_key_here
FCM_SENDER_ID=your_fcm_sender_id
FCM_PROJECT_ID=your_firebase_project_id
FCM_PRIVATE_KEY_ID=your_private_key_id
FCM_PRIVATE_KEY="-----BEGIN PRIVATE KEY-----\nYOUR_PRIVATE_KEY_CONTENT_HERE\n-----END PRIVATE KEY-----"
FCM_CLIENT_EMAIL=firebase-adminsdk-xxxxx@your-project.iam.gserviceaccount.com
FCM_CLIENT_ID=your_client_id
```

### Service Account JSON Example:

```json
{
    "type": "service_account",
    "project_id": "your-project-id",
    "private_key_id": "key-id",
    "private_key": "-----BEGIN PRIVATE KEY-----\n...\n-----END PRIVATE KEY-----\n",
    "client_email": "firebase-adminsdk-xxxxx@your-project.iam.gserviceaccount.com",
    "client_id": "123456789",
    "auth_uri": "https://accounts.google.com/o/oauth2/auth",
    "token_uri": "https://oauth2.googleapis.com/token"
}
```

---

## 🍎 **3. APPLE PUSH NOTIFICATION SERVICE (APNs) - iOS Push**

### What is APNs?

Apple Push Notification service is Apple's solution for sending push notifications to iOS devices. **Optional** if using Expo, but provides more control.

### Required Setup Steps:

#### 3.1 Apple Developer Account

1. You need a **paid Apple Developer account** ($99/year)
2. Go to [https://developer.apple.com/](https://developer.apple.com/)
3. Enroll in the Apple Developer Program

#### 3.2 Create App ID

1. Go to Apple Developer Console → Certificates, Identifiers & Profiles
2. Create a new App ID
3. Enable "Push Notifications" capability
4. Note your Bundle ID (e.g., `com.yourcompany.schoolapp`)

#### 3.3 Create Push Notification Key

1. Go to Keys section in Apple Developer Console
2. Click "Create a key"
3. Enable "Apple Push Notifications service (APNs)"
4. Download the `.p8` file
5. Note the Key ID and Team ID

### Environment Variables Required:

```bash
APNS_KEY_ID=your_apns_key_id
APNS_TEAM_ID=your_apple_team_id
APNS_BUNDLE_ID=com.yourcompany.schoolapp
APNS_PRIVATE_KEY_PATH=/path/to/your/AuthKey_XXXXXXXXXX.p8
APNS_PRODUCTION=false
```

### File Storage:

-   Store the `.p8` file securely on your server
-   Set proper file permissions (600)
-   Update the `APNS_PRIVATE_KEY_PATH` to the file location

---

## 🔄 **4. REAL-TIME BROADCASTING (Laravel Reverb)**

### What is Laravel Reverb?

Laravel Reverb is Laravel's official WebSocket server for real-time features. It's **already configured** but needs proper setup for production.

### Current Configuration:

```bash
BROADCAST_CONNECTION=reverb
REVERB_APP_ID=623485
REVERB_APP_KEY=ftlvjzbndng2pip2xruw
REVERB_APP_SECRET=mjwhbjilpdsiblqexfyk
REVERB_HOST=0.0.0.0
REVERB_PORT=8080
REVERB_SCHEME=http
```

### Production Setup Required:

#### 4.1 SSL/TLS Configuration

For production, you need HTTPS:

```bash
REVERB_SCHEME=https
REVERB_PORT=443
```

#### 4.2 Domain Configuration

```bash
REVERB_HOST=your-domain.com
```

#### 4.3 Alternative: Use Pusher (Optional)

If you prefer Pusher:

1. Sign up at [https://pusher.com/](https://pusher.com/)
2. Create a new app
3. Get your credentials:

```bash
BROADCAST_CONNECTION=pusher
PUSHER_APP_ID=your_pusher_app_id
PUSHER_APP_KEY=your_pusher_key
PUSHER_APP_SECRET=your_pusher_secret
PUSHER_APP_CLUSTER=your_pusher_cluster
```

---

## ⚙️ **5. CONFIGURATION EXAMPLES**

### 5.1 Development Environment (.env)

```bash
# Use Expo for simplicity
PUSH_SERVICE=expo
EXPO_ACCESS_TOKEN=your_expo_token
EXPO_PROJECT_ID=your_project_id

# Local Reverb
BROADCAST_CONNECTION=reverb
REVERB_HOST=127.0.0.1
REVERB_PORT=8080
REVERB_SCHEME=http

# Test tokens
TEST_EXPO_TOKEN=ExponentPushToken[xxxxxxxxxxxxxxxxxxxxxx]
```

### 5.2 Production Environment (.env)

```bash
# Mixed service for maximum compatibility
PUSH_SERVICE=mixed
EXPO_ACCESS_TOKEN=your_expo_token
FCM_SERVER_KEY=your_fcm_key
APNS_KEY_ID=your_apns_key

# Production Reverb with SSL
BROADCAST_CONNECTION=reverb
REVERB_HOST=your-domain.com
REVERB_PORT=443
REVERB_SCHEME=https
```

---

## 🧪 **6. TESTING & VALIDATION**

### 6.1 Test Push Notifications

```bash
# Test with Expo CLI
expo push:android:upload --api-key your_expo_token
expo push:ios:upload --api-key your_expo_token

# Test with curl (FCM)
curl -X POST https://fcm.googleapis.com/fcm/send \
  -H "Authorization: key=YOUR_FCM_SERVER_KEY" \
  -H "Content-Type: application/json" \
  -d '{"to":"YOUR_FCM_TOKEN","notification":{"title":"Test","body":"Hello"}}'
```

### 6.2 Test Real-Time Broadcasting

```bash
# Start Reverb server
php artisan reverb:start

# Test WebSocket connection
wscat -c ws://localhost:8080/app/your_app_key
```

### 6.3 Application Tests

Use the provided API endpoints to test:

```bash
# Register push token
POST /api/user-management/push-tokens/register

# Create test notification
POST /api/communication-management/notifications/create
```

---

## 🚨 **7. SECURITY CONSIDERATIONS**

### 7.1 Environment Variables Security

-   **NEVER** commit API keys to version control
-   Use different keys for development/staging/production
-   Rotate keys regularly (quarterly)
-   Monitor usage in service dashboards

### 7.2 File Permissions

```bash
# Secure .env file
chmod 600 .env

# Secure APNs key file
chmod 600 /path/to/AuthKey_XXXXXXXXXX.p8
```

### 7.3 Network Security

-   Use HTTPS for all production endpoints
-   Implement rate limiting for API endpoints
-   Monitor for suspicious push notification activity

---

## 📞 **8. TROUBLESHOOTING**

### Common Issues:

#### 8.1 "Invalid Token" Errors

-   **Cause**: Using test tokens or expired tokens
-   **Solution**: Get real tokens from actual mobile devices
-   **Debug**: Check `user_push_tokens` table for valid tokens

#### 8.2 Expo Push Failures

-   **Cause**: Invalid Expo access token or project ID
-   **Solution**: Verify credentials in Expo dashboard
-   **Debug**: Check Laravel logs for detailed error messages

#### 8.3 Real-Time Not Working

-   **Cause**: WebSocket connection issues
-   **Solution**: Ensure Reverb server is running and ports are open
-   **Debug**: Check browser console for WebSocket errors

#### 8.4 FCM Authentication Errors

-   **Cause**: Invalid service account credentials
-   **Solution**: Regenerate and download new service account JSON
-   **Debug**: Test FCM credentials independently

#### 8.5 APNs Certificate Issues

-   **Cause**: Expired or invalid certificates
-   **Solution**: Generate new APNs key in Apple Developer Console
-   **Debug**: Check certificate expiration dates

---

## 📞 **9. SUPPORT & RESOURCES**

### Official Documentation:

-   [Expo Push Notifications](https://docs.expo.dev/push-notifications/overview/)
-   [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging)
-   [Apple Push Notifications](https://developer.apple.com/documentation/usernotifications)
-   [Laravel Reverb](https://laravel.com/docs/11.x/reverb)

### Testing Tools:

-   [Expo Push Tool](https://expo.dev/notifications)
-   [FCM Testing Console](https://console.firebase.google.com/)
-   [APNs Tester](https://apps.apple.com/us/app/apns-tester/id1479420408)

### Community Support:

-   [Laravel Community](https://laravel.com/community)
-   [Expo Community](https://expo.dev/community)
-   [Stack Overflow](https://stackoverflow.com/questions/tagged/laravel+push-notifications)

---

## ✅ **10. IMPLEMENTATION CHECKLIST**

### Phase 1: Basic Setup (Required)

-   [ ] Expo account created and access token obtained
-   [ ] Environment variables configured in `.env`
-   [ ] Laravel Reverb server tested locally
-   [ ] Basic push notification tested with Expo

### Phase 2: Enhanced Setup (Recommended)

-   [ ] Firebase project created and FCM configured
-   [ ] Apple Developer account and APNs configured
-   [ ] SSL/TLS configured for production
-   [ ] Mixed push service configuration tested

### Phase 3: Production Deployment (Critical)

-   [ ] All API keys secured and environment-specific
-   [ ] Monitoring and logging configured
-   [ ] Error handling and fallback mechanisms tested
-   [ ] Performance optimization and scaling configured

---

**Need Help?** Contact the development team for assistance with any of these setup steps.

---

**Last Updated:** $(date '+%B %d, %Y')  
**Version:** 1.0  
**Compatibility:** Laravel 11.x, Expo SDK 49+
