#!/bin/bash

# Test script for CreateComment functionality
# This script tests comment creation with smart deactivation logic

echo "=== CreateComment Testing ==="
echo "Testing comment creation with automatic deactivation of previous comments..."

echo ""
echo "Step 1: Create initial feedback (if not exists)"

FEEDBACK_DATA='{
  "student_id": 1,
  "grade_level_id": 1,
  "grade_level_class_id": 1,
  "edu_fb_category_id": 1,
  "rating": 4.0,
  "created_by_designation": "Teacher",
  "comments": "Initial feedback for comment testing"
}'

echo "Creating feedback (if needed)..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/feedback/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$FEEDBACK_DATA" \
  --silent --show-error

echo ""
echo ""
echo "Step 2: Create first comment"

COMMENT_1='{
  "edu_fb_id": 1,
  "comment": "This is the first comment for this feedback"
}'

echo "Creating first comment..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/comment/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$COMMENT_1" \
  --silent --show-error

echo ""
echo ""
echo "Step 3: Create second comment (should deactivate first)"

COMMENT_2='{
  "edu_fb_id": 1,
  "comment": "This is the second comment - the first should be deactivated"
}'

echo "Creating second comment..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/comment/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$COMMENT_2" \
  --silent --show-error

echo ""
echo ""
echo "Step 4: Create third comment (should deactivate second)"

COMMENT_3='{
  "edu_fb_id": 1,
  "comment": "This is the third comment - all previous should be deactivated"
}'

echo "Creating third comment..."
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/comment/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$COMMENT_3" \
  --silent --show-error

echo ""
echo ""
echo "=== Expected Results ==="
echo "✅ First comment created (is_active = true)"
echo "✅ Second comment created (first becomes is_active = false, second is_active = true)"
echo "✅ Third comment created (first & second become is_active = false, third is_active = true)"

echo ""
echo "=== Final State Verification ==="
echo "Should have 3 comments for feedback:"
echo "1. First comment (is_active = false)"
echo "2. Second comment (is_active = false)"
echo "3. Third comment (is_active = true)"

echo ""
echo "=== Database Verification Query ==="
echo "SELECT id, edu_fb_id, comment, is_active, created_at"
echo "FROM edu_fb_comment"
echo "WHERE edu_fb_id = 1"
echo "ORDER BY created_at;"

echo ""
echo "=== Test Instructions ==="
echo "1. Replace 'YOUR_TOKEN_HERE' with actual authentication token"
echo "2. Ensure feedback_id=1 exists or use different ID"
echo "3. Run: bash test_create_comment.sh"
echo "4. Check database to verify:"
echo "   - Only the latest comment has is_active = true"
echo "   - All previous comments have is_active = false"
echo "   - Activity logs are created for each comment"

echo ""
echo "=== Smart Comment Behavior ==="
echo "- When creating new comment for feedback_id X:"
echo "- All existing comments for feedback_id X get is_active = false"
echo "- New comment gets is_active = true"
echo "- Complete audit trail maintained"

echo ""
echo "=== Test Complete ==="