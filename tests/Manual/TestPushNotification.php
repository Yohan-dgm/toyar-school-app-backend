<?php

use Modules\UserManagement\Models\User;
use Modules\UserManagement\Models\UserPushToken;
use Modules\CommunicationManagement\Intents\Notification\CreateNotification\CreateNotificationAction;
use Illuminate\Support\Facades\Log;

use Spatie\Multitenancy\Models\Tenant;

// 0. Set Tenant Context (CRITICAL for Multi-tenancy)
// We specifically want Tenant 2 (Nexis College) as Tenant 1 (Fallback) is empty
$tenant = Tenant::find(2);
if (!$tenant) {
    echo "Tenant ID 2 not found. Trying first()...\n";
    $tenant = Tenant::first();
}
if (!$tenant) {
    echo "No tenants found. Please create a tenant first.\n";
    exit;
}
$tenant->makeCurrent();
echo "Switched to Tenant: {$tenant->name} (DB: {$tenant->database})\n";

// 1. Get or Create a Test User
$user = User::first();
if (!$user) {
    echo "No users found in database. Please seed users first.\n";
    exit;
}
echo "Using User ID: {$user->id} ({$user->name})\n";

// 2. Create/Update Dummy Push Token for this User
// Token 1
$token1 = 'ExponentPushToken[TestToken1_' . time() . ']';
UserPushToken::createOrUpdateToken($user->id, 'device-id-1-' . time(), $token1, UserPushToken::PLATFORM_ANDROID);
echo "Token 1 Created: $token1\n";

// Token 2 (To prove it sends to ALL tokens)
$token2 = 'ExponentPushToken[TestToken2_' . time() . ']';
UserPushToken::createOrUpdateToken($user->id, 'device-id-2-' . time(), $token2, UserPushToken::PLATFORM_IOS);
echo "Token 2 Created: $token2\n";

echo "User {$user->id} now has valid tokens.\n";

// 3. Create Notification Payload
$payload = [
    'notification_type_id' => 1, // Ensure this exists or use a valid ID
    'title' => 'Test Push Notification ' . time(),
    'message' => 'This is a test notification to verify queue processing.',
    'priority' => 'urgent', // Urgent to use high priority queue if configured
    'target_type' => 'user',
    'target_data' => [
        'user_id' => $user->id
    ],
    'is_scheduled' => false
];

$actionData = [
    'created_by' => $user->id
];

// 4. Trigger Notification Creation
try {
    echo "Creating Notification...\n";
    $result = CreateNotificationAction::run($payload, $actionData);
    
    echo "Notification Created ID: {$result->id}\n";
    echo "Check your logs for 'Starting push notification job'.\n";
    echo "Run 'php artisan queue:work' to process the job if not running.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    Log::error("Manual Test Error: " . $e->getMessage());
}
