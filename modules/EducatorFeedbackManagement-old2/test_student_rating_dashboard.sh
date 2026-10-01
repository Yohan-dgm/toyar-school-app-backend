#!/bin/bash

# Test script for GetStudentRatingDashboard API endpoint
# Usage: ./test_student_rating_dashboard.sh

echo "=========================================="
echo "Testing Student Rating Dashboard API"
echo "=========================================="

BASE_URL="http://localhost:8000/api/educator-feedback-management"
ENDPOINT="$BASE_URL/dashboard/student-ratings"

# Test case 1: Basic request with student_id only
echo "Test 1: Basic request with student_id only"
echo "----------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1
  }' | jq '.'

echo -e "\n\n"

# Test case 2: Request with year filter
echo "Test 2: Request with year filter (2024)"
echo "----------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "year": 2024
  }' | jq '.'

echo -e "\n\n"

# Test case 3: Request with year and month filter
echo "Test 3: Request with year and month filter (2024-08)"
echo "----------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "year": 2024,
    "month": 8
  }' | jq '.'

echo -e "\n\n"

# Test case 4: Request with custom status
echo "Test 4: Request with custom status (status=1)"
echo "----------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "status": 1
  }' | jq '.'

echo -e "\n\n"

# Test case 5: Request with all filters
echo "Test 5: Request with all filters"
echo "---------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "year": 2024,
    "month": 8,
    "status": 2
  }' | jq '.'

echo -e "\n\n"

# Test case 6: Invalid student_id (validation error)
echo "Test 6: Invalid student_id (validation error)"
echo "----------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": "invalid"
  }' | jq '.'

echo -e "\n\n"

# Test case 7: Missing student_id (validation error)
echo "Test 7: Missing student_id (validation error)"
echo "----------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{}' | jq '.'

echo -e "\n\n"

# Test case 8: Non-existent student
echo "Test 8: Non-existent student (student_id=99999)"
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