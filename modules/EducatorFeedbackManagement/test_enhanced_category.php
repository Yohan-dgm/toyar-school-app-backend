<?php

/**
 * Test script for Enhanced Category Creation
 * This script tests the new category creation functionality with questions and answers
 */

require_once __DIR__.'/../../vendor/autoload.php';

use Modules\EducatorFeedbackManagement\Intents\Category\CreateCategory\CreateCategoryAction;

// Test data for enhanced category creation
$testData = [
    'name' => 'Test Academic Performance Category',
    'is_active' => true,
    'predefined_questions' => [
        [
            'question' => 'How is the student\'s class participation?',
            'edu_fb_answer_type_id' => 1,
            'is_active' => true,
            'predefined_answers' => [
                [
                    'predefined_answer' => 'Excellent',
                    'predefined_answer_weight' => 5,
                    'marks' => 10,
                    'is_active' => true,
                ],
                [
                    'predefined_answer' => 'Good',
                    'predefined_answer_weight' => 4,
                    'marks' => 8,
                    'is_active' => true,
                ],
                [
                    'predefined_answer' => 'Average',
                    'predefined_answer_weight' => 3,
                    'marks' => 6,
                    'is_active' => true,
                ],
            ],
        ],
        [
            'question' => 'How is the student\'s homework completion?',
            'edu_fb_answer_type_id' => 1,
            'is_active' => true,
            'predefined_answers' => [
                [
                    'predefined_answer' => 'Always completed on time',
                    'predefined_answer_weight' => 5,
                    'marks' => 10,
                    'is_active' => true,
                ],
                [
                    'predefined_answer' => 'Usually completed',
                    'predefined_answer_weight' => 4,
                    'marks' => 8,
                    'is_active' => true,
                ],
            ],
        ],
    ],
];

$actionData = [
    'user_id' => 1,
    'username' => 'test_user',
];

echo "=== Enhanced Category Creation Test ===\n";
echo "Testing category creation with questions and answers...\n";

try {
    // Test the enhanced category creation
    $result = CreateCategoryAction::run($testData, $actionData);

    echo "✅ SUCCESS: Category created successfully!\n";
    echo 'Category ID: '.$result->id."\n";
    echo 'Category Name: '.$result->name."\n";
    echo 'Questions Created: '.count($result->predefined_questions)."\n";

    $totalAnswers = 0;
    foreach ($result->predefined_questions as $question) {
        $totalAnswers += count($question->predefined_answers);
        echo '  - Question: '.$question->question.' (Answers: '.count($question->predefined_answers).")\n";
    }

    echo 'Total Answers Created: '.$totalAnswers."\n";

} catch (Exception $e) {
    echo '❌ ERROR: '.$e->getMessage()."\n";
    echo 'File: '.$e->getFile()."\n";
    echo 'Line: '.$e->getLine()."\n";
}

echo "\n=== Test Complete ===\n";
