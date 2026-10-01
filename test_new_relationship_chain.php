<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use Modules\EducatorManagement\Intents\Educator\GetEducatorClassStudents\GetEducatorClassStudentsAction;
use Modules\UserManagement\Models\User;

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

// Set the correct database connection
config(['database.connections.pgsqlt.database' => 'school_app']);
config(['database.default' => 'pgsqlt']);

echo "🧪 TESTING NEW RELATIONSHIP CHAIN: educator_grade_level_pivot\n";
echo "=" . str_repeat("=", 65) . "\n\n";

// Test data for different scenarios with new expected results
$testCases = [
    [
        'name' => 'Educator 1 (User ID 1) - Has access to Grade 1 ONLY',
        'user_id' => 1,
        'expected_students' => ['John Doe', 'Jane Smith', 'Bob Wilson', 'Alice Brown'],
        'expected_grade_level' => 'Grade 1'
    ],
    [
        'name' => 'Educator 2 (User ID 2) - Has access to Grade 1 AND Grade 2', 
        'user_id' => 2,
        'expected_students' => ['John Doe', 'Jane Smith', 'Bob Wilson', 'Alice Brown', 'Charlie Davis'],
        'expected_grade_levels' => ['Grade 1', 'Grade 2']
    ],
    [
        'name' => 'Educator 3 (User ID 3) - Has access to Grade 2 ONLY',
        'user_id' => 3,
        'expected_students' => ['Charlie Davis'],
        'expected_grade_level' => 'Grade 2'
    ],
    [
        'name' => 'Admin User (User ID 4) - Should be denied access',
        'user_id' => 4,
        'expected_error' => 'Access denied. Only educators can access this endpoint.'
    ]
];

$totalTests = 0;
$passedTests = 0;

// Test each scenario
foreach ($testCases as $testCase) {
    echo "🔍 Testing: {$testCase['name']}\n";
    echo str_repeat("-", 70) . "\n";
    
    try {
        $authenticatedUser = User::find($testCase['user_id']);
        if (!$authenticatedUser) {
            echo "❌ User not found: {$testCase['user_id']}\n\n";
            continue;
        }
        
        echo "✅ User found: {$authenticatedUser->email} (category: {$authenticatedUser->user_category})\n";
        
        $payloadArray = [
            'page_size' => 10,
            'page' => 1,
            'search_phrase' => null
        ];
        
        $actionData = ['authenticatedUser' => $authenticatedUser];
        
        // Test basic functionality
        $totalTests++;
        echo "📋 Testing basic functionality...\n";
        
        try {
            $result = GetEducatorClassStudentsAction::run($payloadArray, $actionData);
            
            if (isset($testCase['expected_error'])) {
                echo "❌ Expected error but got successful result\n";
            } else {
                echo "✅ Action executed successfully!\n";
                echo "📊 Results: {$result->total()} students found\n";
                
                $studentNames = [];
                $gradeLevels = [];
                foreach ($result->items() as $student) {
                    $studentNames[] = $student->full_name;
                    if ($student->grade_level) {
                        $gradeLevels[] = $student->grade_level->name;
                    }
                    
                    echo "   - {$student->full_name}\n";
                    echo "     Grade Level: " . ($student->grade_level ? $student->grade_level->name : 'N/A') . "\n";
                    echo "     Class: " . ($student->grade_level_class ? $student->grade_level_class->name : 'N/A') . "\n";
                    
                    // Check attachments
                    if ($student->student_attachment_list && count($student->student_attachment_list) > 0) {
                        echo "     📎 Attachments: " . count($student->student_attachment_list) . "\n";
                    } else {
                        echo "     📎 No attachments\n";
                    }
                    echo "\n";
                }
                
                // Verify expected students
                if (isset($testCase['expected_students'])) {
                    $missing = array_diff($testCase['expected_students'], $studentNames);
                    $extra = array_diff($studentNames, $testCase['expected_students']);
                    
                    if (empty($missing) && empty($extra)) {
                        echo "✅ Student list matches expectations\n";
                        $passedTests++;
                    } else {
                        echo "❌ Student list mismatch:\n";
                        if (!empty($missing)) echo "   Missing: " . implode(', ', $missing) . "\n";
                        if (!empty($extra)) echo "   Extra: " . implode(', ', $extra) . "\n";
                    }
                }
                
                // Verify grade levels
                $uniqueGradeLevels = array_unique($gradeLevels);
                echo "📈 Grade levels covered: " . implode(', ', $uniqueGradeLevels) . "\n";
            }
            
        } catch (Exception $e) {
            if (isset($testCase['expected_error']) && $e->getMessage() === $testCase['expected_error']) {
                echo "✅ Expected error received: {$e->getMessage()}\n";
                $passedTests++;
            } else {
                echo "❌ Unexpected error: {$e->getMessage()}\n";
            }
        }
        
    } catch (Exception $e) {
        echo "❌ Setup error: {$e->getMessage()}\n";
    }
    
    echo "\n" . str_repeat("=", 70) . "\n\n";
}

// Test cross-educator security with the new broader scope
echo "🔒 SECURITY TEST: Cross-Educator Access with Grade Level Scope\n";
echo str_repeat("-", 70) . "\n";

$totalTests++;
try {
    // Educator 1 should now see ALL Grade 1 students (John, Jane, Bob, Alice)
    // but NOT Grade 2 students (Charlie)
    $educator1 = User::find(1);
    $payloadArray = ['page_size' => 10, 'page' => 1, 'search_phrase' => 'Charlie'];
    $actionData = ['authenticatedUser' => $educator1];
    
    $result = GetEducatorClassStudentsAction::run($payloadArray, $actionData);
    
    $foundCharlie = false;
    foreach ($result->items() as $student) {
        if ($student->full_name === 'Charlie Davis') {
            $foundCharlie = true;
            break;
        }
    }
    
    if (!$foundCharlie) {
        echo "✅ SECURITY PASSED: Educator 1 correctly cannot see Charlie Davis (Grade 2 student)\n";
        $passedTests++;
    } else {
        echo "❌ SECURITY ISSUE: Educator 1 should not see Charlie Davis (Grade 2 student)\n";
    }
    
} catch (Exception $e) {
    echo "❌ Security test failed: {$e->getMessage()}\n";
}

// Summary
echo "\n🏁 TEST SUMMARY\n";
echo str_repeat("=", 30) . "\n";
echo "Total Tests: {$totalTests}\n";
echo "Passed: {$passedTests}\n";
echo "Failed: " . ($totalTests - $passedTests) . "\n";
echo "Success Rate: " . round(($passedTests / $totalTests) * 100, 1) . "%\n\n";

if ($passedTests === $totalTests) {
    echo "🎉 ALL TESTS PASSED! The new relationship chain is working correctly.\n";
} else {
    echo "⚠️  Some tests failed. Please review the issues above.\n";
}

echo "\n✨ Testing completed!\n";