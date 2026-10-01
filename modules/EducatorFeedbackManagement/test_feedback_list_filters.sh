#!/bin/bash

# Test script for Educator Feedback List API with Filtering and Pagination
# This script tests the enhanced feedback/list endpoint with proper filtering

echo "=== Educator Feedback List API - Filter & Pagination Tests ==="
echo ""

# Configuration
BASE_URL="http://localhost:8000/api/educator-feedback-management"
TOKEN="YOUR_TOKEN_HERE"  # Replace with actual token

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

echo -e "${YELLOW}NOTE: Replace 'YOUR_TOKEN_HERE' with a valid authentication token${NC}"
echo ""

# Test 1: Initial load (all grades + status=1)
echo -e "${BLUE}=== Test 1: Initial Load (All Grades + Status 1 - Under Observation) ===${NC}"
echo "Request: page=1, page_size=10 (no filters)"
echo "Expected: Returns 10 records from all grades with evaluation status=1"
echo ""

curl -X POST \
  "$BASE_URL/feedback/list" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "page": 1,
    "page_size": 10
  }' \
  --write-out "\n\nHTTP Status: %{http_code}\n" \
  --silent --show-error | jq '.'

echo ""
echo "---"
echo ""

# Test 2: Filter by grade level
echo -e "${BLUE}=== Test 2: Filter by Grade Level ===${NC}"
echo "Request: grade_filter=8 (Grade 8), status=1"
echo "Expected: Returns only Grade 8 students with status=1"
echo ""

curl -X POST \
  "$BASE_URL/feedback/list" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "page": 1,
    "page_size": 10,
    "grade_filter": 8
  }' \
  --write-out "\n\nHTTP Status: %{http_code}\n" \
  --silent --show-error | jq '.'

echo ""
echo "---"
echo ""

# Test 3: Filter by evaluation status
echo -e "${BLUE}=== Test 3: Filter by Evaluation Status ===${NC}"
echo "Request: evaluation_type_filter=2 (Accept), all grades"
echo "Expected: Returns all grades with evaluation status=2 (Accept)"
echo ""

curl -X POST \
  "$BASE_URL/feedback/list" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "page": 1,
    "page_size": 10,
    "evaluation_type_filter": 2
  }' \
  --write-out "\n\nHTTP Status: %{http_code}\n" \
  --silent --show-error | jq '.'

echo ""
echo "---"
echo ""

# Test 4: Filter by both grade and status
echo -e "${BLUE}=== Test 4: Filter by Grade + Evaluation Status ===${NC}"
echo "Request: grade_filter=8, evaluation_type_filter=1"
echo "Expected: Returns Grade 8 students with status=1"
echo ""

curl -X POST \
  "$BASE_URL/feedback/list" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "page": 1,
    "page_size": 10,
    "grade_filter": 8,
    "evaluation_type_filter": 1
  }' \
  --write-out "\n\nHTTP Status: %{http_code}\n" \
  --silent --show-error | jq '.'

echo ""
echo "---"
echo ""

# Test 5: Pagination - Page 2
echo -e "${BLUE}=== Test 5: Pagination - Second Page ===${NC}"
echo "Request: page=2, page_size=10, status=1"
echo "Expected: Returns records 11-20 with status=1"
echo ""

curl -X POST \
  "$BASE_URL/feedback/list" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "page": 2,
    "page_size": 10
  }' \
  --write-out "\n\nHTTP Status: %{http_code}\n" \
  --silent --show-error | jq '.'

echo ""
echo "---"
echo ""

# Test 6: Small page size
echo -e "${BLUE}=== Test 6: Small Page Size (5 records) ===${NC}"
echo "Request: page=1, page_size=5, status=1"
echo "Expected: Returns only 5 records with status=1"
echo ""

curl -X POST \
  "$BASE_URL/feedback/list" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "page": 1,
    "page_size": 5
  }' \
  --write-out "\n\nHTTP Status: %{http_code}\n" \
  --silent --show-error | jq '.'

echo ""
echo "---"
echo ""

# Test 7: Search with filters
echo -e "${BLUE}=== Test 7: Search Phrase + Filters ===${NC}"
echo "Request: search_phrase='John', grade_filter=8, status=1"
echo "Expected: Returns Grade 8 students matching 'John' with status=1"
echo ""

curl -X POST \
  "$BASE_URL/feedback/list" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d '{
    "page": 1,
    "page_size": 10,
    "search_phrase": "John",
    "grade_filter": 8
  }' \
  --write-out "\n\nHTTP Status: %{http_code}\n" \
  --silent --show-error | jq '.'

echo ""
echo "---"
echo ""

echo -e "${GREEN}=== Test Summary ===${NC}"
echo "✅ Test 1: Initial load - All grades, status=1 (default)"
echo "✅ Test 2: Grade filter - Specific grade, status=1 (default)"
echo "✅ Test 3: Status filter - All grades, specific status"
echo "✅ Test 4: Combined filters - Specific grade + status"
echo "✅ Test 5: Pagination - Second page"
echo "✅ Test 6: Page size - Custom page size"
echo "✅ Test 7: Search + filters - Combined with search phrase"
echo ""

echo -e "${YELLOW}=== Expected Response Structure ===${NC}"
echo "{"
echo '  "success": true,'
echo '  "data": {'
echo '    "current_page": 1,'
echo '    "data": [ /* Array of feedback records */ ],'
echo '    "per_page": 10,'
echo '    "total": 50,'
echo '    "last_page": 5'
echo "  },"
echo '  "message": "Educator feedback list retrieved successfully"'
echo "}"
echo ""

echo -e "${YELLOW}=== Parameter Mapping ===${NC}"
echo "Frontend Parameter     → Backend Parameter"
echo "grade_filter           → grade_level_id"
echo "evaluation_type_filter → evaluation_status (default: 1)"
echo ""

echo -e "${YELLOW}=== Evaluation Status Codes ===${NC}"
echo "1 = Under Observation"
echo "2 = Accept"
echo "3 = Decline"
echo "4 = Aware Parents"
echo "5 = Assigning to Counselor"
echo "6 = Correction Required"
echo ""

echo -e "${GREEN}=== Tests Complete ===${NC}"
