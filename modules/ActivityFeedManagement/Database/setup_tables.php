<?php

/**
 * Database Setup Script for Activity Feed Management
 * 
 * This script creates the necessary tables and inserts dummy data
 * for the Activity Feed Management module.
 */

use Illuminate\Support\Facades\DB;

try {
    echo "Setting up Activity Feed Management tables...\n";

    // Read and execute SQL files
    $sqlFiles = [
        'activity_feed_posts.sql',
        'activity_feed_media.sql', 
        'activity_feed_hashtags.sql',
        'activity_feed_likes.sql'
    ];

    foreach ($sqlFiles as $sqlFile) {
        $filePath = __DIR__ . '/Sql/' . $sqlFile;
        
        if (file_exists($filePath)) {
            echo "Executing {$sqlFile}...\n";
            $sql = file_get_contents($filePath);
            DB::unprepared($sql);
            echo "✓ {$sqlFile} executed successfully\n";
        } else {
            echo "✗ {$sqlFile} not found\n";
        }
    }

    echo "\n✅ Activity Feed Management tables setup completed successfully!\n";
    echo "\nYou can now test the following API endpoints:\n";
    echo "POST /api/activity-feed-management/school-posts/create\n";
    echo "POST /api/activity-feed-management/school-posts/list\n";
    echo "POST /api/activity-feed-management/school-posts/update\n";
    echo "POST /api/activity-feed-management/school-posts/toggle-like\n";

} catch (Exception $e) {
    echo "❌ Error setting up tables: " . $e->getMessage() . "\n";
    exit(1);
}
