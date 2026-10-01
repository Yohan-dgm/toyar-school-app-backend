#!/bin/bash

# Test script for GetStudentRatingByTerm API endpoint
# Usage: ./test_student_rating_by_term.sh

echo "=========================================="
echo "Testing Student Rating By Term API"
echo "=========================================="

BASE_URL="http://localhost:8000/api/educator-feedback-management"
ENDPOINT="$BASE_URL/dashboard/student-ratings-by-term"

# Test case 1: Basic request with student_id only (current year)
echo "Test 1: Basic request with student_id only (current year)"
echo "---------------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1
  }' | jq '.'

echo -e "\n\n"

# Test case 2: Request with specific year (2024)
echo "Test 2: Request with specific year (2024)"
echo "-----------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "year": 2024
  }' | jq '.'

echo -e "\n\n"

# Test case 3: Request with specific year (2023)
echo "Test 3: Request with specific year (2023)"
echo "-----------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "year": 2023
  }' | jq '.'

echo -e "\n\n"

# Test case 4: Different student
echo "Test 4: Different student (student_id=2)"
echo "----------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 2,
    "year": 2024
  }' | jq '.'

echo -e "\n\n"

# Test case 5: Missing required field (validation error)
echo "Test 5: Missing student_id (validation error)"
echo "---------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "year": 2024
  }' | jq '.'

echo -e "\n\n"

# Test case 6: Invalid data types (validation error)
echo "Test 6: Invalid data types (validation error)"
echo "---------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": "invalid",
    "year": "invalid"
  }' | jq '.'

echo -e "\n\n"

# Test case 7: Year out of range (validation error)
echo "Test 7: Year out of range (validation error)"
echo "--------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "year": 2019
  }' | jq '.'

echo -e "\n\n"

# Test case 8: Future year
echo "Test 8: Future year (2025)"
echo "--------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "year": 2025
  }' | jq '.'

echo -e "\n\n"

# Test case 9: Non-existent student
echo "Test 9: Non-existent student (student_id=99999)"
echo "-----------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 99999,
    "year": 2024
  }' | jq '.'

echo -e "\n\n"

echo "=========================================="
echo "Term Date Ranges Explanation:"
echo "Term 1: September 1 - December 31 (Year)"
echo "Term 2: January 1 - April 30 (Year+1)"
echo "Term 3: May 1 - August 30 (Year+1)"
echo ""
echo "Example for year=2024:"
echo "Term 1: 2024-09-01 to 2024-12-31"
echo "Term 2: 2025-01-01 to 2025-04-30"
echo "Term 3: 2025-05-01 to 2025-08-30"
echo "=========================================="
echo "Test script completed"
echo "=========================================="