#!/bin/bash

echo "=== Complete Comment Flow Test ==="
echo "This script tests the complete flow: Create Feedback -> Create Comments"
echo ""

# Replace with your actual token
TOKEN="YOUR_TOKEN_HERE"
BASE_URL="http://localhost:8000/api/educator-feedback-management"

echo "Step 1: Create a feedback record first"
echo "POST $BASE_URL/feedback/create"
echo ""

FEEDBACK_DATA='{
  "student_id": 1,
  "grade_level_id": 1,
  "grade_level_class_id": 1,
  "edu_fb_category_id": 1,
  "rating": 4.0,
  "created_by_designation": "Mathematics Teacher",
  "comments": "Initial feedback for comment testing"
}'

echo "Creating feedback..."
FEEDBACK_RESPONSE=$(curl -X POST \
  $BASE_URL/feedback/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d "$FEEDBACK_DATA" \
  --silent --show-error)

echo "Feedback Response:"
echo "$FEEDBACK_RESPONSE"
echo ""
echo "=================="
echo ""

# Extract feedback ID from response (you may need to adjust this based on actual response)
# For now, we'll assume feedback ID is 1
FEEDBACK_ID=1

echo "Step 2: Create first comment for feedback ID: $FEEDBACK_ID"
echo "POST $BASE_URL/comment/create"
echo ""

COMMENT_1='{
  "edu_fb_id": '$FEEDBACK_ID',
  "comment": "This is the first comment for this feedback"
}'

echo "Creating first comment..."
COMMENT_1_RESPONSE=$(curl -X POST \
  $BASE_URL/comment/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d "$COMMENT_1" \
  --silent --show-error)

echo "First Comment Response:"
echo "$COMMENT_1_RESPONSE"
echo ""
echo "=================="
echo ""

echo "Step 3: Create second comment (should deactivate first)"
echo "POST $BASE_URL/comment/create"
echo ""

COMMENT_2='{
  "edu_fb_id": '$FEEDBACK_ID',
  "comment": "This is the second comment - the first should be deactivated"
}'

echo "Creating second comment..."
COMMENT_2_RESPONSE=$(curl -X POST \
  $BASE_URL/comment/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d "$COMMENT_2" \
  --silent --show-error)

echo "Second Comment Response:"
echo "$COMMENT_2_RESPONSE"
echo ""
echo "=================="
echo ""

echo "Step 4: Create third comment (should deactivate previous)"
echo "POST $BASE_URL/comment/create"
echo ""

COMMENT_3='{
  "edu_fb_id": '$FEEDBACK_ID',
  "comment": "This is the third comment - all previous should be deactivated"
}'

echo "Creating third comment..."
COMMENT_3_RESPONSE=$(curl -X POST \
  $BASE_URL/comment/create \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d "$COMMENT_3" \
  --silent --show-error)

echo "Third Comment Response:"
echo "$COMMENT_3_RESPONSE"
echo ""
echo "=================="
echo ""

echo "Step 5: Verify feedback list shows comments correctly"
echo "POST $BASE_URL/feedback/list"
echo ""

LIST_DATA='{
  "page_size": 10,
  "page": 1
}'

echo "Getting feedback list..."
LIST_RESPONSE=$(curl -X POST \
  $BASE_URL/feedback/list \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d "$LIST_DATA" \
  --silent --show-error)

echo "Feedback List Response:"
echo "$LIST_RESPONSE"
echo ""

echo "=== Expected Results ==="
echo "✅ Feedback created successfully"
echo "✅ First comment created (is_active = true)"
echo "✅ Second comment created (first becomes is_active = false, second is_active = true)"
echo "✅ Third comment created (first & second become is_active = false, third is_active = true)"
echo "✅ Feedback list shows all comments with proper is_active status"
echo ""

echo "=== Database Verification Query ==="
echo "SELECT id, edu_fb_id, comment, is_active, created_at"
echo "FROM edu_fb_comment"
echo "WHERE edu_fb_id = $FEEDBACK_ID"
echo "ORDER BY created_at;"
echo ""

echo "=== Instructions ==="
echo "1. Replace 'YOUR_TOKEN_HERE' with actual authentication token"
echo "2. Ensure server is running: composer dev"
echo "3. Make sure these records exist in database:"
echo "   - Student with ID 1"
echo "   - Grade level with ID 1"
echo "   - Grade level class with ID 1"
echo "   - Category with ID 1"
echo "4. Run: bash test_complete_comment_flow.sh"
echo ""

echo "=== Alternative: Test with existing feedback ==="
echo "If you already have feedback records, you can test comments directly:"
echo ""
echo "# Find existing feedback ID"
echo "curl -X POST \\"
echo "  $BASE_URL/feedback/list \\"
echo "  -H \"Content-Type: application/json\" \\"
echo "  -H \"Authorization: Bearer YOUR_TOKEN\" \\"
echo "  -d '{\"page_size\": 10, \"page\": 1}'"
echo ""
echo "# Then use that feedback ID for comment creation"
echo "curl -X POST \\"
echo "  $BASE_URL/comment/create \\"
echo "  -H \"Content-Type: application/json\" \\"
echo "  -H \"Authorization: Bearer YOUR_TOKEN\" \\"
echo "  -d '{\"edu_fb_id\": EXISTING_FEEDBACK_ID, \"comment\": \"Test comment\"}'"