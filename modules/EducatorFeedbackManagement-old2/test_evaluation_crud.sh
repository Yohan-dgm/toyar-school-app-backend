#!/bin/bash

# Test script for Evaluation CRUD operations
# This script tests update and delete evaluation functionality

echo "=== Evaluation CRUD Testing ==="
echo "Testing evaluation update and delete operations..."

echo ""
echo "Step 1: Create initial feedback (auto-creates evaluation)"

FEEDBACK_DATA='{
  "student_id": 1,
  "grade_level_id": 1,
  "grade_level_class_id": 1,
  "edu_fb_category_id": 1,
  "rating": 4.0,
  "created_by_designation": "Teacher",
  "comments": "Initial feedback for CRUD testing"
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
echo "Step 2: Create additional evaluation"

EVALUATION_CREATE='{
  "edu_fb_id": 1,
  "edu_fd_evaluation_type_id": 2,
  "reviewer_feedback": "Second evaluation for testing",
  "is_parent_visible": true
}'

echo "Creating additional evaluation..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/evaluation/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$EVALUATION_CREATE" \
  --silent --show-error

echo ""
echo ""
echo "Step 3: Update the evaluation"

EVALUATION_UPDATE='{
  "id": 2,
  "edu_fd_evaluation_type_id": 3,
  "reviewer_feedback": "Updated evaluation feedback - now declined",
  "decline_reason": "Needs more supporting evidence",
  "is_parent_visible": false,
  "is_active": true
}'

echo "Updating evaluation..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/evaluation/update \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$EVALUATION_UPDATE" \
  --silent --show-error

echo ""
echo ""
echo "Step 4: Create third evaluation (should deactivate updated one)"

EVALUATION_CREATE_2='{
  "edu_fb_id": 1,
  "edu_fd_evaluation_type_id": 4,
  "reviewer_feedback": "Third evaluation - parents aware",
  "is_parent_visible": true
}'

echo "Creating third evaluation..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/evaluation/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$EVALUATION_CREATE_2" \
  --silent --show-error

echo ""
echo ""
echo "Step 5: Delete the second evaluation"

EVALUATION_DELETE='{
  "id": 2
}'

echo "Deleting second evaluation..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/evaluation/delete \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$EVALUATION_DELETE" \
  --silent --show-error

echo ""
echo ""
echo "=== Expected Results ==="
echo "✅ Feedback created with auto-evaluation (status 1)"
echo "✅ Second evaluation created (status 2, becomes active)"
echo "✅ Second evaluation updated (status 3, decline reason added)"
echo "✅ Third evaluation created (status 4, second becomes inactive)"
echo "✅ Second evaluation deleted (third remains active)"

echo ""
echo "=== Final State Verification ==="
echo "Should have 2 evaluations for feedback:"
echo "1. Auto-created evaluation (status 1, inactive)"
echo "2. Third evaluation (status 4, active)"

echo ""
echo "=== Database Verification Query ==="
echo "SELECT id, edu_fb_id, edu_fd_evaluation_type_id, reviewer_feedback, is_active, created_at"
echo "FROM edu_fd_evaluation"
echo "WHERE edu_fb_id = 1"
echo "ORDER BY created_at;"

echo ""
echo "=== Test Instructions ==="
echo "1. Replace 'YOUR_TOKEN_HERE' with actual authentication token"
echo "2. Ensure feedback_id=1 doesn't exist or use different IDs"
echo "3. Run: bash test_evaluation_crud.sh"
echo "4. Check database to verify:"
echo "   - Second evaluation is deleted"
echo "   - Third evaluation is active"
echo "   - Auto-created evaluation is inactive"

echo ""
echo "=== Test Complete ==="