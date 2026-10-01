<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Push Notification Service
    |--------------------------------------------------------------------------
    |
    | This option controls the default push notification service that will be
    | used by the application. You may set this to any of the services
    | defined in the "services" array below.
    |
    | Supported: "expo", "fcm", "apns", "mixed"
    |
    */

    'default' => env('PUSH_SERVICE', 'expo'),

    /*
    |--------------------------------------------------------------------------
    | Push Notification Services
    |--------------------------------------------------------------------------
    |
    | Here you may configure the push notification services that your
    | application will use to send push notifications to mobile devices.
    |
    */

    'services' => [

        'expo' => [
            'driver' => 'expo',
            'access_token' => env('EXPO_ACCESS_TOKEN'),
            'project_id' => env('EXPO_PROJECT_ID'),
            'push_url' => 'https://exp.host/--/api/v2/push/send',
            'receipt_url' => 'https://exp.host/--/api/v2/push/getReceipts',
            'options' => [
                'batch_size' => env('PUSH_BATCH_SIZE', 100),
                'max_retries' => env('PUSH_MAX_RETRIES', 3),
                'retry_delay' => env('PUSH_RETRY_DELAY', 1000), // milliseconds
                'timeout' => env('PUSH_TIMEOUT', 30), // seconds
            ],
        ],

        'fcm' => [
            'driver' => 'fcm',
            'server_key' => env('FCM_SERVER_KEY'),
            'sender_id' => env('FCM_SENDER_ID'),
            'project_id' => env('FCM_PROJECT_ID'),
            'service_account' => [
                'private_key_id' => env('FCM_PRIVATE_KEY_ID'),
                'private_key' => env('FCM_PRIVATE_KEY'),
                'client_email' => env('FCM_CLIENT_EMAIL'),
                'client_id' => env('FCM_CLIENT_ID'),
                'auth_uri' => env('FCM_AUTH_URI', 'https://accounts.google.com/o/oauth2/auth'),
                'token_uri' => env('FCM_TOKEN_URI', 'https://oauth2.googleapis.com/token'),
            ],
            'push_url' => 'https://fcm.googleapis.com/fcm/send',
            'options' => [
                'batch_size' => env('PUSH_BATCH_SIZE', 100),
                'max_retries' => env('PUSH_MAX_RETRIES', 3),
                'retry_delay' => env('PUSH_RETRY_DELAY', 1000),
                'timeout' => env('PUSH_TIMEOUT', 30),
            ],
        ],

        'apns' => [
            'driver' => 'apns',
            'key_id' => env('APNS_KEY_ID'),
            'team_id' => env('APNS_TEAM_ID'),
            'bundle_id' => env('APNS_BUNDLE_ID'),
            'private_key_path' => env('APNS_PRIVATE_KEY_PATH'),
            'production' => env('APNS_PRODUCTION', false),
            'options' => [
                'max_retries' => env('PUSH_MAX_RETRIES', 3),
                'retry_delay' => env('PUSH_RETRY_DELAY', 1000),
                'timeout' => env('PUSH_TIMEOUT', 30),
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Notification Settings
    |--------------------------------------------------------------------------
    |
    | General settings for the notification system.
    |
    */

    'settings' => [
        'default_priority' => env('NOTIFICATION_DEFAULT_PRIORITY', 'normal'),
        'max_recipients' => env('NOTIFICATION_MAX_RECIPIENTS', 1000),
        'cleanup_days' => env('NOTIFICATION_CLEANUP_DAYS', 90),
        'stats_cache_ttl' => env('NOTIFICATION_STATS_CACHE_TTL', 300), // seconds
    ],

    /*
    |--------------------------------------------------------------------------
    | Queue Configuration
    |--------------------------------------------------------------------------
    |
    | Queue names for different priority levels and operations.
    |
    */

    'queues' => [
        'notification' => [
            'high' => env('QUEUE_NOTIFICATION_HIGH', 'notification-high'),
            'normal' => env('QUEUE_NOTIFICATION_NORMAL', 'notification-normal'),
            'low' => env('QUEUE_NOTIFICATION_LOW', 'notification-low'),
        ],
        'broadcast' => [
            'high' => env('QUEUE_BROADCAST_HIGH', 'broadcast-high'),
            'normal' => env('QUEUE_BROADCAST_NORMAL', 'broadcast-normal'),
        ],
        'push' => [
            'urgent' => env('QUEUE_PUSH_URGENT', 'push-urgent'),
            'high' => env('QUEUE_PUSH_HIGH', 'push-high'),
            'normal' => env('QUEUE_PUSH_NORMAL', 'push-normal'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Development & Testing
    |--------------------------------------------------------------------------
    |
    | Settings for development and testing environments.
    |
    */

    'testing' => [
        'test_tokens' => [
            'expo' => env('TEST_EXPO_TOKEN'),
            'fcm' => env('TEST_FCM_TOKEN'),
            'apns' => env('TEST_APNS_TOKEN'),
        ],
        'debug' => [
            'notification' => env('NOTIFICATION_DEBUG', false),
            'push_notification' => env('PUSH_NOTIFICATION_DEBUG', false),
            'broadcast' => env('BROADCAST_DEBUG', false),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Platform Specific Settings
    |--------------------------------------------------------------------------
    |
    | Platform-specific configuration for iOS and Android.
    |
    */

    'platforms' => [
        'ios' => [
            'sound' => 'default',
            'badge' => true,
            'alert' => true,
            'content_available' => true,
            'mutable_content' => true,
        ],
        'android' => [
            'sound' => 'default',
            'vibrate' => true,
            'lights' => true,
            'channel_id' => 'default',
            'notification_priority' => 'high',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Error Handling
    |--------------------------------------------------------------------------
    |
    | Configuration for push notification error handling.
    |
    */

    'error_handling' => [
        'max_failures' => 5,
        'failure_threshold_hours' => 24,
        'auto_cleanup_invalid_tokens' => true,
        'notify_user_on_failure' => true,
        'retry_invalid_tokens' => false,
    ],

];