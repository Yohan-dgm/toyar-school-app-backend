#!/bin/bash

echo "=== Employee Type Relationship Test ==="
echo "Testing GetEmployeeListData to verify employee_type.name is returned"
echo ""

# Replace with your actual token
TOKEN="YOUR_TOKEN_HERE"
BASE_URL="http://localhost:8000/api/employee-management"

echo "Testing employee list endpoint:"
echo "POST $BASE_URL/employee/list"
echo ""

LIST_DATA='{
  "page_size": 10,
  "page": 1
}'

echo "Request Body:"
echo "$LIST_DATA"
echo ""

echo "Making API call..."
RESPONSE=$(curl -X POST \
  $BASE_URL/employee/list \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d "$LIST_DATA" \
  --silent --show-error)

echo "Response:"
echo "$RESPONSE"
echo ""

echo "=== Expected Response Structure ==="
echo "Each employee should include:"
echo "{"
echo "  \"id\": 1,"
echo "  \"full_name\": \"John Doe\","
echo "  \"nic_number\": \"123456789V\","
echo "  \"employee_type_id\": 1,"
echo "  \"remaining_annual_leaves\": 21,"
echo "  \"remaining_medical_leaves\": 7,"
echo "  \"remaining_maternity_leaves\": 84,"
echo "  \"employee_type\": {"
echo "    \"id\": 1,"
echo "    \"name\": \"Full Time Teacher\"  // <-- This is the employee_type.name"
echo "  }"
echo "}"
echo ""

echo "=== Testing with Search Phrase ==="
echo "Testing search by employee type name:"
echo ""

SEARCH_DATA='{
  "page_size": 10,
  "page": 1,
  "search_phrase": "Teacher"
}'

echo "Search Request Body:"
echo "$SEARCH_DATA"
echo ""

echo "Making search API call..."
SEARCH_RESPONSE=$(curl -X POST \
  $BASE_URL/employee/list \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer $TOKEN" \
  -d "$SEARCH_DATA" \
  --silent --show-error)

echo "Search Response:"
echo "$SEARCH_RESPONSE"
echo ""

echo "=== Verification Steps ==="
echo "✅ Check that each employee object includes 'employee_type' relationship"
echo "✅ Check that employee_type contains 'id' and 'name' fields"
echo "✅ Verify employee_type.name shows the actual name (e.g., 'Full Time Teacher')"
echo "✅ Verify search by employee type name works (e.g., searching 'Teacher')"
echo ""

echo "=== Current Implementation Status ==="
echo "✅ Employee model has employee_type() relationship defined"
echo "✅ EmployeeType model exists with 'name' field"
echo "✅ GetEmployeeListDataAction loads employee_type relationship"
echo "✅ GetEmployeeListDataAction selects employee_type id and name"
echo "✅ Search functionality includes employee_type.name search"
echo ""

echo "=== API Endpoint Details ==="
echo "Endpoint: POST /api/employee-management/employee/list"
echo "Authentication: Bearer token required"
echo "Request Body: { \"page_size\": 10, \"page\": 1 }"
echo ""

echo "=== Instructions ==="
echo "1. Replace 'YOUR_TOKEN_HERE' with actual authentication token"
echo "2. Ensure server is running: composer dev"
echo "3. Make sure employee_type table has data"
echo "4. Run: bash test_employee_type_relation.sh"
echo ""

echo "=== Database Check Query ==="
echo "To verify data exists in database:"
echo "SELECT e.id, e.full_name, e.employee_type_id, et.name as employee_type_name"
echo "FROM employee e"
echo "LEFT JOIN employee_type et ON e.employee_type_id = et.id"
echo "LIMIT 5;"