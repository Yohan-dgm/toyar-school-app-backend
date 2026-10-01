#!/bin/bash

# Test script for Enhanced Category Creation API
# This script tests the new category creation functionality with questions and answers

echo "=== Enhanced Category Creation API Test ==="
echo "Testing category creation with questions and answers..."

# Define the test data
JSON_DATA='{
  "name": "Test Academic Performance Category",
  "is_active": true,
  "predefined_questions": [
    {
      "question": "How is the student'\''s class participation?",
      "edu_fb_answer_type_id": 1,
      "is_active": true,
      "predefined_answers": [
        {
          "predefined_answer": "Excellent",
          "predefined_answer_weight": 5,
          "marks": 10,
          "is_active": true
        },
        {
          "predefined_answer": "Good",
          "predefined_answer_weight": 4,
          "marks": 8,
          "is_active": true
        },
        {
          "predefined_answer": "Average",
          "predefined_answer_weight": 3,
          "marks": 6,
          "is_active": true
        }
      ]
    },
    {
      "question": "How is the student'\''s homework completion?",
      "edu_fb_answer_type_id": 1,
      "is_active": true,
      "predefined_answers": [
        {
          "predefined_answer": "Always completed on time",
          "predefined_answer_weight": 5,
          "marks": 10,
          "is_active": true
        },
        {
          "predefined_answer": "Usually completed",
          "predefined_answer_weight": 4,
          "marks": 8,
          "is_active": true
        }
      ]
    }
  ]
}'

echo "Sending POST request to create category with questions and answers..."

# Make the API call (Note: You'll need to replace with actual auth token)
curl -X POST \
  http://localhost:8000/api/educator-feedback-management/category/create \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -d "$JSON_DATA" \
  --write-out "\n\nHTTP Status: %{http_code}\n" \
  --silent --show-error

echo ""
echo "=== Test Instructions ==="
echo "1. First authenticate via user management system to get token"
echo "2. Replace 'YOUR_TOKEN_HERE' with actual authentication token"
echo "3. Run this script: bash test_category_api.sh"
echo "4. Check the response for successful category creation with questions and answers"
echo ""
echo "Expected Response Structure:"
echo "- Category object with id, name, is_active"
echo "- predefined_questions array with question details"
echo "- Each question has predefined_answers array"
echo "- All relationships properly loaded"

echo ""
echo "=== Test Complete ==="