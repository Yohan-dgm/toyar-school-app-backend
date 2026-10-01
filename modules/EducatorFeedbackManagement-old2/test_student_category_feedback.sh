#!/bin/bash

# Test script for GetStudentCategoryFeedbackList API endpoint
# Usage: ./test_student_category_feedback.sh

echo "=========================================="
echo "Testing Student Category Feedback List API"
echo "=========================================="

BASE_URL="http://localhost:8000/api/educator-feedback-management"
ENDPOINT="$BASE_URL/student-category-feedback/list"

# Test case 1: Basic request with required fields only
echo "Test 1: Basic request with required fields (student_id=1)"
echo "---------------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1
  }' | jq '.'

echo -e "\n\n"

# Test case 2: Request with custom page size
echo "Test 2: Request with custom page size (5 records per page)"
echo "--------------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "page_size": 5
  }' | jq '.'

echo -e "\n\n"

# Test case 3: Request with pagination (page 2)
echo "Test 3: Request with pagination (page 2)"
echo "----------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "page": 2,
    "page_size": 5
  }' | jq '.'

echo -e "\n\n"

# Test case 4: Request with date filter
echo "Test 4: Request with date filter (2024 records)"
echo "-----------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "date_from": "2024-01-01",
    "date_to": "2024-12-31"
  }' | jq '.'

echo -e "\n\n"

# Test case 5: Request with search phrase
echo "Test 5: Request with search phrase"
echo "----------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "search_phrase": "good"
  }' | jq '.'

echo -e "\n\n"

# Test case 6: Request with different evaluation status
echo "Test 6: Request with evaluation status = 1 (Under Observation)"
echo "-------------------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "evaluation_status": 1
  }' | jq '.'

echo -e "\n\n"

# Test case 7: Request with additional filters
echo "Test 7: Request with additional filters"
echo "--------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "filters": {
      "grade_level_id": 1
    }
  }' | jq '.'

echo -e "\n\n"

# Test case 8: Request with all parameters
echo "Test 8: Request with all parameters"
echo "-----------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "page": 1,
    "page_size": 3,
    "evaluation_status": 2,
    "date_from": "2024-01-01",
    "date_to": "2024-12-31",
    "search_phrase": "feedback"
  }' | jq '.'

echo -e "\n\n"

# Test case 9: Missing required field (validation error)
echo "Test 9: Missing required field - student_id (validation error)"
echo "-------------------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{}' | jq '.'

echo -e "\n\n"

# Test case 10: Invalid data types (validation error)
echo "Test 10: Invalid data types (validation error)"
echo "----------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": "invalid"
  }' | jq '.'

echo -e "\n\n"

# Test case 11: Non-existent student
echo "Test 11: Non-existent student (student_id=99999)"
echo "------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 99999
  }' | jq '.'

echo -e "\n\n"

echo "=========================================="
echo "Test script completed"
echo "=========================================="