#!/bin/bash

# Test script for GetStudentAttendanceById API endpoint
# Usage: ./test_student_attendance_by_id.sh

echo "=========================================="
echo "Testing Student Attendance By ID API"
echo "=========================================="

BASE_URL="http://localhost:8000/api/attendance-management"
ENDPOINT="$BASE_URL/student-attendance/get-student-attendance-by-id"

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

# Test case 5: Request with attendance type filter
echo "Test 5: Request with attendance type filter (Present - Type 1)"
echo "-------------------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "attendance_type_id": 1
  }' | jq '.'

echo -e "\n\n"

# Test case 6: Request with search phrase
echo "Test 6: Request with search phrase"
echo "----------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "search_phrase": "late"
  }' | jq '.'

echo -e "\n\n"

# Test case 7: Request with all parameters
echo "Test 7: Request with all parameters"
echo "-----------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "page": 1,
    "page_size": 3,
    "date_from": "2024-01-01",
    "date_to": "2024-12-31",
    "attendance_type_id": 1,
    "search_phrase": "on time"
  }' | jq '.'

echo -e "\n\n"

# Test case 8: Missing required field (validation error)
echo "Test 8: Missing required field - student_id (validation error)"
echo "-------------------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{}' | jq '.'

echo -e "\n\n"

# Test case 9: Invalid data types (validation error)
echo "Test 9: Invalid data types (validation error)"
echo "---------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": "invalid"
  }' | jq '.'

echo -e "\n\n"

# Test case 10: Non-existent student
echo "Test 10: Non-existent student (student_id=99999)"
echo "------------------------------------------------"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 99999
  }' | jq '.'

echo -e "\n\n"

# Test case 11: Different attendance types
echo "Test 11: Filter by different attendance types"
echo "--------------------------------------------"
echo "Attendance Type 2 (Out):"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "attendance_type_id": 2
  }' | jq '.'

echo -e "\n"
echo "Attendance Type 3 (Leave):"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "attendance_type_id": 3
  }' | jq '.'

echo -e "\n"
echo "Attendance Type 4 (Absent):"
curl -X POST "$ENDPOINT" \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer test-token" \
  -d '{
    "student_id": 1,
    "attendance_type_id": 4
  }' | jq '.'

echo -e "\n\n"

echo "=========================================="
echo "Test script completed"
echo "Expected Response Structure:"
echo "{"
echo "  \"data\": ["
echo "    {"
echo "      \"id\": 1,"
echo "      \"student_id\": 1,"
echo "      \"date\": \"2024-08-18\","
echo "      \"time\": \"08:30:00\","
echo "      \"attendance_type_id\": 1,"
echo "      \"notes\": \"On time\","
echo "      \"student\": { \"full_name\": \"...\", \"admission_number\": \"...\" },"
echo "      \"attendance_type\": { \"name\": \"In\" },"
echo "      \"grade_level_class\": { \"name\": \"...\" },"
echo "      \"attendance_reason\": { \"reason\": \"...\" }"
echo "    }"
echo "  ],"
echo "  \"pagination\": { \"current_page\": 1, \"total\": 50 }"
echo "}"
echo "=========================================="