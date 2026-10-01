<?php

require_once __DIR__.'/vendor/autoload.php';

use Modules\ActivityFeedManagement\Intents\ClassPost\ToggleLike\ToggleLikeAction as ClassPostToggleLikeAction;
use Modules\ActivityFeedManagement\Intents\SchoolPost\ToggleLike\ToggleLikeAction as SchoolPostToggleLikeAction;
use Modules\ActivityFeedManagement\Intents\StudentPost\ToggleLike\ToggleLikeAction as StudentPostToggleLikeAction;

// Bootstrap Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Toggle Like Functionality ===\n\n";

// Test data
$userId = 1;
$schoolPostId = 1;
$classPostId = 1;
$studentPostId = 1;

echo "1. Testing School Post Toggle Like\n";
echo "==================================\n";

try {
    // Test liking a school post
    $result = SchoolPostToggleLikeAction::run(
        ['post_id' => $schoolPostId, 'action' => 'like'],
        ['user_id' => $userId]
    );

    echo "✓ School Post LIKE result:\n";
    echo '  Post ID: '.$result['post_id']."\n";
    echo '  Is Liked: '.($result['is_liked_by_user'] ? 'true' : 'false')."\n";
    echo '  Likes Count: '.$result['likes_count']."\n\n";

    // Test unliking the same school post
    $result = SchoolPostToggleLikeAction::run(
        ['post_id' => $schoolPostId, 'action' => 'unlike'],
        ['user_id' => $userId]
    );

    echo "✓ School Post UNLIKE result:\n";
    echo '  Post ID: '.$result['post_id']."\n";
    echo '  Is Liked: '.($result['is_liked_by_user'] ? 'true' : 'false')."\n";
    echo '  Likes Count: '.$result['likes_count']."\n\n";

} catch (Exception $e) {
    echo '✗ School Post test failed: '.$e->getMessage()."\n\n";
}

echo "2. Testing Class Post Toggle Like\n";
echo "=================================\n";

try {
    // Test liking a class post
    $result = ClassPostToggleLikeAction::run(
        ['post_id' => $classPostId, 'action' => 'like'],
        ['user_id' => $userId]
    );

    echo "✓ Class Post LIKE result:\n";
    echo '  Post ID: '.$result['post_id']."\n";
    echo '  Is Liked: '.($result['is_liked_by_user'] ? 'true' : 'false')."\n";
    echo '  Likes Count: '.$result['likes_count']."\n\n";

    // Test unliking the same class post
    $result = ClassPostToggleLikeAction::run(
        ['post_id' => $classPostId, 'action' => 'unlike'],
        ['user_id' => $userId]
    );

    echo "✓ Class Post UNLIKE result:\n";
    echo '  Post ID: '.$result['post_id']."\n";
    echo '  Is Liked: '.($result['is_liked_by_user'] ? 'true' : 'false')."\n";
    echo '  Likes Count: '.$result['likes_count']."\n\n";

} catch (Exception $e) {
    echo '✗ Class Post test failed: '.$e->getMessage()."\n\n";
}

echo "3. Testing Student Post Toggle Like\n";
echo "===================================\n";

try {
    // Test liking a student post
    $result = StudentPostToggleLikeAction::run(
        ['post_id' => $studentPostId, 'action' => 'like'],
        ['user_id' => $userId]
    );

    echo "✓ Student Post LIKE result:\n";
    echo '  Post ID: '.$result['post_id']."\n";
    echo '  Is Liked: '.($result['is_liked_by_user'] ? 'true' : 'false')."\n";
    echo '  Likes Count: '.$result['likes_count']."\n\n";

    // Test unliking the same student post
    $result = StudentPostToggleLikeAction::run(
        ['post_id' => $studentPostId, 'action' => 'unlike'],
        ['user_id' => $userId]
    );

    echo "✓ Student Post UNLIKE result:\n";
    echo '  Post ID: '.$result['post_id']."\n";
    echo '  Is Liked: '.($result['is_liked_by_user'] ? 'true' : 'false')."\n";
    echo '  Likes Count: '.$result['likes_count']."\n\n";

} catch (Exception $e) {
    echo '✗ Student Post test failed: '.$e->getMessage()."\n\n";
}

echo "=== Testing Complete ===\n";
