#!/bin/bash

# Test script for Educator Feedback Creation with Auto-Evaluation
# This script tests that feedback creation automatically creates an evaluation with status 1

echo "=== Educator Feedback Creation with Auto-Evaluation Test ==="
echo "Testing that feedback creation automatically creates evaluation..."

# Define the test data
JSON_DATA='{
  "student_id": 1,
  "grade_level_id": 1,
  "grade_level_class_id": 1,
  "edu_fb_category_id": 1,
  "rating": 4.5,
  "created_by_designation": "Head Teacher",
  "comments": "Student shows good improvement in mathematics - Testing auto-evaluation creation",
  "question_answers": [
    {
      "edu_fb_predefined_question_id": 1,
      "edu_fb_predefined_answer_id": 1,
      "selected_predefined_answer_id": 1,
      "answer_mark": 8
    }
  ],
  "subcategories": [
    {
      "subcategory_name": "Mathematics Performance"
    }
  ]
}'

echo "Sending POST request to create educator feedback..."
echo "Expected: Feedback should be created with automatic evaluation (status = 1)"

# Make the API call (Note: You'll need to replace with actual auth token)
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/feedback/create \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$JSON_DATA" \
  --write-out "\n\nHTTP Status: %{http_code}\n" \
  --silent --show-error

echo ""
echo "=== Expected Response Structure ==="
echo "✅ Should include 'evaluations' array in response"
echo "✅ First evaluation should have:"
echo "   - edu_fd_evaluation_type_id: 1"
echo "   - reviewer_feedback: 'Feedback under initial observation'"
echo "   - is_parent_visible: false"
echo "   - is_active: true"
echo "   - evaluation_type.status_code: 1"
echo "   - evaluation_type.name: 'Under Observation'"

echo ""
echo "=== Verification Steps ==="
echo "1. Check that 'evaluations' array is present in response"
echo "2. Verify evaluation has edu_fd_evaluation_type_id = 1"
echo "3. Confirm evaluation_type shows 'Under Observation'"
echo "4. Ensure evaluation is linked to the created feedback"

echo ""
echo "=== Test Instructions ==="
echo "1. First authenticate via user management system to get token"
echo "2. Replace 'YOUR_TOKEN_HERE' with actual authentication token"
echo "3. Ensure prerequisite data exists (student_id=1, grade_level_id=1, category_id=1)"
echo "4. Run: bash test_feedback_with_evaluation.sh"
echo "5. Verify response contains auto-created evaluation"

echo ""
echo "=== Test Complete ==="