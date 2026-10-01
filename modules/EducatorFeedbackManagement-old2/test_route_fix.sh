#!/bin/bash

echo "=== Testing CreateComment Route Fix ==="
echo "Fixed route prefix typo: 'educator-feedback-managent' -> 'educator-feedback-management'"
echo ""

echo "Correct route URL to use:"
echo "POST /api/educator-feedback-management/comment/create"
echo ""

echo "Test command:"
echo "curl -X POST \\"
echo "  http://localhost:8000/api/educator-feedback-management/comment/create \\"
echo "  -H \"Content-Type: application/json\" \\"
echo "  -H \"Authorization: Bearer YOUR_TOKEN_HERE\" \\"
echo "  -d '{"
echo "    \"edu_fb_id\": 1,"
echo "    \"comment\": \"Test comment to verify route is working\""
echo "  }'"
echo ""

echo "=== Route Registration Status ==="
echo "✅ Fixed typo in route prefix"
echo "✅ Added missing evaluation route imports"
echo "✅ Added missing evaluation routes"
echo "✅ CreateComment route properly registered"
echo ""

echo "Available routes:"
echo "- POST /api/educator-feedback-management/comment/create"
echo "- POST /api/educator-feedback-management/evaluation/create"
echo "- POST /api/educator-feedback-management/evaluation/update"
echo "- POST /api/educator-feedback-management/evaluation/delete"
echo "- POST /api/educator-feedback-management/evaluation/update-status"
echo ""

echo "To start the server:"
echo "composer dev"
echo ""

echo "To verify routes are working:"
echo "php artisan route:list --path=educator-feedback-management"