#!/bin/bash

# Test script for CreateEvaluation functionality
# This script tests the new evaluation creation that deactivates previous evaluations

echo "=== CreateEvaluation Functionality Test ==="
echo "Testing that new evaluation creation deactivates all previous evaluations..."

# Test data for creating multiple evaluations for the same feedback
echo "Step 1: Create initial feedback (this will auto-create evaluation with status 1)"

FEEDBACK_DATA='{
  "student_id": 1,
  "grade_level_id": 1,
  "grade_level_class_id": 1,
  "edu_fb_category_id": 1,
  "rating": 4.0,
  "created_by_designation": "Teacher",
  "comments": "Initial feedback for evaluation testing"
}'

echo "Creating feedback..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/feedback/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$FEEDBACK_DATA" \
  --silent --show-error

echo ""
echo ""
echo "Step 2: Create first additional evaluation (status 1 -> 2)"

EVALUATION_1='{
  "edu_fb_id": 1,
  "edu_fd_evaluation_type_id": 2,
  "reviewer_feedback": "First evaluation - feedback accepted",
  "is_parent_visible": true
}'

echo "Creating first evaluation..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/evaluation/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$EVALUATION_1" \
  --silent --show-error

echo ""
echo ""
echo "Step 3: Create second additional evaluation (status 2 -> 4)"

EVALUATION_2='{
  "edu_fb_id": 1,
  "edu_fd_evaluation_type_id": 4,
  "reviewer_feedback": "Second evaluation - parents made aware",
  "is_parent_visible": true
}'

echo "Creating second evaluation..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/evaluation/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$EVALUATION_2" \
  --silent --show-error

echo ""
echo ""
echo "Step 4: Create third evaluation (status 4 -> 6)"

EVALUATION_3='{
  "edu_fb_id": 1,
  "edu_fd_evaluation_type_id": 6,
  "reviewer_feedback": "Third evaluation - corrections required",
  "is_parent_visible": false
}'

echo "Creating third evaluation..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/evaluation/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$EVALUATION_3" \
  --silent --show-error

echo ""
echo ""
echo "=== Expected Behavior ==="
echo "✅ Each evaluation creation should:"
echo "   - Set ALL previous evaluations is_active = false"
echo "   - Set ONLY the new evaluation is_active = true"
echo "   - Return the new evaluation with proper relationships"
echo "   - Update the main feedback status"
echo ""
echo "✅ Database should have:"
echo "   - 4 total evaluation records for feedback_id = 1"
echo "   - Only 1 evaluation with is_active = true (the latest)"
echo "   - 3 evaluations with is_active = false (all previous)"

echo ""
echo "=== Verification Query (Run in database) ==="
echo "SELECT id, edu_fb_id, edu_fd_evaluation_type_id, is_active, created_at"
echo "FROM edu_fd_evaluation"
echo "WHERE edu_fb_id = 1"
echo "ORDER BY created_at;"

echo ""
echo "=== Test Instructions ==="
echo "1. Replace 'YOUR_TOKEN_HERE' with actual authentication token"
echo "2. Ensure feedback_id=1 doesn't exist or use different IDs"
echo "3. Run: bash test_create_evaluation.sh"
echo "4. Check database to verify only latest evaluation is active"
echo "5. Verify response shows proper evaluation_type relationships"

echo ""
echo "=== Test Complete ==="