<?php

/**
 * Test Class and Student Post Field Updates
 *
 * This script tests:
 * - Class posts with grade_level_class_id field
 * - Student posts with student_id field
 * - Create and list operations for both post types
 *
 * Run: php test_class_student_post_fields.php
 */

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Modules\ActivityFeedManagement\Models\ClassPost;
use Modules\ActivityFeedManagement\Models\StudentPost;

// Initialize Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "🧪 CLASS AND STUDENT POST FIELD TESTING\n";
echo "========================================\n\n";

class PostFieldTester
{
    private $testResults = [];

    public function runAllTests()
    {
        echo "📋 Starting class and student post field tests...\n\n";

        // Test 1: Verify database schema
        $this->testDatabaseSchema();

        // Test 2: Test class post creation with grade_level_class_id
        $this->testClassPostCreation();

        // Test 3: Test class post listing with grade_level_class_id filtering
        $this->testClassPostListing();

        // Test 4: Test student post creation with student_id
        $this->testStudentPostCreation();

        // Test 5: Test student post listing with student_id filtering
        $this->testStudentPostListing();

        // Print results
        $this->printResults();
    }

    private function testDatabaseSchema()
    {
        echo "1️⃣ Testing database schema...\n";

        try {
            // Check if grade_level_class_id exists in class_posts
            $classPostColumns = DB::select("
                SELECT column_name, data_type 
                FROM information_schema.columns 
                WHERE table_name = 'class_posts' AND column_name = 'grade_level_class_id'
            ");

            if (! empty($classPostColumns)) {
                echo "   ✅ grade_level_class_id column exists in class_posts table\n";
                $this->testResults['class_posts_schema'] = 'PASS';
            } else {
                throw new Exception('grade_level_class_id column missing from class_posts table');
            }

            // Check if student_id exists in student_posts
            $studentPostColumns = DB::select("
                SELECT column_name, data_type 
                FROM information_schema.columns 
                WHERE table_name = 'student_posts' AND column_name = 'student_id'
            ");

            if (! empty($studentPostColumns)) {
                echo "   ✅ student_id column exists in student_posts table\n";
                $this->testResults['student_posts_schema'] = 'PASS';
            } else {
                throw new Exception('student_id column missing from student_posts table');
            }

            echo "\n";

        } catch (Exception $e) {
            echo '   ❌ Database schema test failed: '.$e->getMessage()."\n\n";
            $this->testResults['database_schema'] = 'FAIL';
        }
    }

    private function testClassPostCreation()
    {
        echo "2️⃣ Testing class post creation with grade_level_class_id...\n";

        try {
            $classPostData = [
                'type' => 'announcement',
                'category' => 'Test',
                'title' => 'Test Class Post with Grade Level',
                'content' => 'This is a test class post with grade_level_class_id field.',
                'author_id' => 1,
                'school_id' => 1,
                'class_id' => 1,
                'grade_level_class_id' => 999, // Test value
                'likes_count' => 0,
                'comments_count' => 0,
                'is_active' => true,
                'created_by' => 1,
            ];

            $classPost = ClassPost::create($classPostData);

            if ($classPost && $classPost->grade_level_class_id == 999) {
                echo "   ✅ Class post created successfully with grade_level_class_id\n";
                echo "      - Post ID: {$classPost->id}\n";
                echo "      - Grade Level Class ID: {$classPost->grade_level_class_id}\n";
                echo "      - Title: {$classPost->title}\n";

                $this->testResults['class_post_creation'] = 'PASS';
                $this->testResults['test_class_post_id'] = $classPost->id;
            } else {
                throw new Exception('Class post creation failed or grade_level_class_id not set correctly');
            }

            echo "\n";

        } catch (Exception $e) {
            echo '   ❌ Class post creation failed: '.$e->getMessage()."\n\n";
            $this->testResults['class_post_creation'] = 'FAIL';
        }
    }

    private function testClassPostListing()
    {
        echo "3️⃣ Testing class post listing with grade_level_class_id filtering...\n";

        try {
            // Test filtering by grade_level_class_id
            $posts = ClassPost::query()
                ->byGradeLevelClass(999)
                ->active()
                ->get();

            if ($posts->count() > 0) {
                echo "   ✅ Class post filtering by grade_level_class_id works\n";
                echo "      - Found {$posts->count()} post(s) with grade_level_class_id = 999\n";

                foreach ($posts as $post) {
                    echo "      - Post #{$post->id}: {$post->title} (Grade Level Class: {$post->grade_level_class_id})\n";
                }

                $this->testResults['class_post_listing'] = 'PASS';
            } else {
                throw new Exception('No posts found with grade_level_class_id filtering');
            }

            echo "\n";

        } catch (Exception $e) {
            echo '   ❌ Class post listing failed: '.$e->getMessage()."\n\n";
            $this->testResults['class_post_listing'] = 'FAIL';
        }
    }

    private function testStudentPostCreation()
    {
        echo "4️⃣ Testing student post creation with student_id...\n";

        try {
            $studentPostData = [
                'type' => 'achievement',
                'category' => 'Academic',
                'title' => 'Test Student Post',
                'content' => 'This is a test student post with student_id field.',
                'author_id' => 1,
                'school_id' => 1,
                'class_id' => 1,
                'student_id' => 888, // Test value
                'likes_count' => 0,
                'comments_count' => 0,
                'is_active' => true,
                'created_by' => 1,
            ];

            $studentPost = StudentPost::create($studentPostData);

            if ($studentPost && $studentPost->student_id == 888) {
                echo "   ✅ Student post created successfully with student_id\n";
                echo "      - Post ID: {$studentPost->id}\n";
                echo "      - Student ID: {$studentPost->student_id}\n";
                echo "      - Title: {$studentPost->title}\n";

                $this->testResults['student_post_creation'] = 'PASS';
                $this->testResults['test_student_post_id'] = $studentPost->id;
            } else {
                throw new Exception('Student post creation failed or student_id not set correctly');
            }

            echo "\n";

        } catch (Exception $e) {
            echo '   ❌ Student post creation failed: '.$e->getMessage()."\n\n";
            $this->testResults['student_post_creation'] = 'FAIL';
        }
    }

    private function testStudentPostListing()
    {
        echo "5️⃣ Testing student post listing with student_id filtering...\n";

        try {
            // Test filtering by student_id
            $posts = StudentPost::query()
                ->byStudent(888)
                ->active()
                ->get();

            if ($posts->count() > 0) {
                echo "   ✅ Student post filtering by student_id works\n";
                echo "      - Found {$posts->count()} post(s) with student_id = 888\n";

                foreach ($posts as $post) {
                    echo "      - Post #{$post->id}: {$post->title} (Student ID: {$post->student_id})\n";
                }

                $this->testResults['student_post_listing'] = 'PASS';
            } else {
                throw new Exception('No posts found with student_id filtering');
            }

            echo "\n";

        } catch (Exception $e) {
            echo '   ❌ Student post listing failed: '.$e->getMessage()."\n\n";
            $this->testResults['student_post_listing'] = 'FAIL';
        }
    }

    private function printResults()
    {
        echo "📊 TEST RESULTS SUMMARY\n";
        echo "=======================\n\n";

        $passes = 0;
        $fails = 0;

        foreach ($this->testResults as $test => $result) {
            if (str_contains($test, '_id')) {
                continue;
            } // Skip ID storage results

            $emoji = $result === 'PASS' ? '✅' : '❌';
            $testName = ucwords(str_replace('_', ' ', $test));
            echo "$emoji $testName: $result\n";

            if ($result === 'PASS') {
                $passes++;
            } else {
                $fails++;
            }
        }

        echo "\n";
        echo "📈 OVERALL RESULTS:\n";
        echo "✅ Passed: $passes\n";
        echo "❌ Failed: $fails\n";
        echo '📊 Total Tests: '.($passes + $fails)."\n\n";

        if ($fails === 0) {
            echo "🎉 ALL TESTS PASSED! Both field updates are working correctly.\n\n";
            echo "✅ CONFIRMED FUNCTIONALITY:\n";
            echo "📌 Class Posts:\n";
            echo "   - grade_level_class_id field can be stored and retrieved\n";
            echo "   - Filtering by grade_level_class_id works correctly\n";
            echo "   - Database schema includes the new field\n\n";
            echo "📌 Student Posts:\n";
            echo "   - student_id field is properly handled\n";
            echo "   - Filtering by student_id works correctly\n";
            echo "   - Database schema supports student_id field\n\n";
            echo "🚀 READY FOR PRODUCTION:\n";
            echo "- Class post APIs can accept and filter by grade_level_class_id\n";
            echo "- Student post APIs can accept and filter by student_id\n";
            echo "- Both create and list operations work correctly\n";
        } else {
            echo "⚠️ Some tests failed. Please review and fix issues.\n";
        }

        // Cleanup test data
        $this->cleanup();
    }

    private function cleanup()
    {
        echo "\n🧹 Cleaning up test data...\n";

        try {
            if (isset($this->testResults['test_class_post_id'])) {
                ClassPost::find($this->testResults['test_class_post_id'])?->delete();
                echo "   ✅ Deleted test class post\n";
            }

            if (isset($this->testResults['test_student_post_id'])) {
                StudentPost::find($this->testResults['test_student_post_id'])?->delete();
                echo "   ✅ Deleted test student post\n";
            }

        } catch (Exception $e) {
            echo '   ⚠️ Cleanup warning: '.$e->getMessage()."\n";
        }
    }
}

// Run the test
$tester = new PostFieldTester;
$tester->runAllTests();

echo 'Test completed at: '.date('Y-m-d H:i:s')."\n";
