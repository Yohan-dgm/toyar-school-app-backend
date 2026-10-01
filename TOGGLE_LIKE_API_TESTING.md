# Activity Feed Management - Toggle Like API Testing Guide

This document provides comprehensive testing examples for the Activity Feed Management toggle-like APIs using Postman.

## 📋 Table of Contents

1. [Authentication Setup](#authentication-setup)
2. [Base Configuration](#base-configuration)
3. [School Posts Toggle-Like API](#school-posts-toggle-like-api)
4. [Class Posts Toggle-Like API](#class-posts-toggle-like-api)
5. [Student Posts Toggle-Like API](#student-posts-toggle-like-api)
6. [Error Handling Examples](#error-handling-examples)
7. [Postman Collection Setup](#postman-collection-setup)
8. [Testing Scenarios](#testing-scenarios)

## 🔐 Authentication Setup

All APIs require authentication using the custom `AuthGuard` middleware.

### Required Headers
```
Authorization: Bearer your_token_here
Content-Type: application/json
Accept: application/json
```

### Environment Variables (Recommended)
```
BASE_URL: http://localhost:8000
API_PREFIX: /api/activity-feed-management
TOKEN: your_auth_token_here
```

## ⚙️ Base Configuration

### Base URL
```
{{BASE_URL}}{{API_PREFIX}}
```

Example: `http://localhost:8000/api/activity-feed-management`

## 🏫 School Posts Toggle-Like API

### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/school-posts/toggle-like
```

### Request Headers
```
Authorization: Bearer {{TOKEN}}
Content-Type: application/json
Accept: application/json
```

### Like a School Post

#### Request Body
```json
{
    "post_id": 1,
    "action": "like"
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Post liked successfully",
    "data": {
        "post_id": 1,
        "is_liked_by_user": true,
        "likes_count": 1
    }
}
```

### Unlike a School Post

#### Request Body
```json
{
    "post_id": 1,
    "action": "unlike"
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Post unliked successfully",
    "data": {
        "post_id": 1,
        "is_liked_by_user": false,
        "likes_count": 0
    }
}
```

## 🎓 Class Posts Toggle-Like API

### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/class-posts/toggle-like
```

### Request Headers
```
Authorization: Bearer {{TOKEN}}
Content-Type: application/json
Accept: application/json
```

### Like a Class Post

#### Request Body
```json
{
    "post_id": 1,
    "action": "like"
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Class post liked successfully",
    "data": {
        "post_id": 1,
        "is_liked_by_user": true,
        "likes_count": 1
    }
}
```

### Unlike a Class Post

#### Request Body
```json
{
    "post_id": 1,
    "action": "unlike"
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Class post unliked successfully",
    "data": {
        "post_id": 1,
        "is_liked_by_user": false,
        "likes_count": 0
    }
}
```

## 👨‍🎓 Student Posts Toggle-Like API

### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/student-posts/toggle-like
```

### Request Headers
```
Authorization: Bearer {{TOKEN}}
Content-Type: application/json
Accept: application/json
```

### Like a Student Post

#### Request Body
```json
{
    "post_id": 1,
    "action": "like"
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Student post liked successfully",
    "data": {
        "post_id": 1,
        "is_liked_by_user": true,
        "likes_count": 1
    }
}
```

### Unlike a Student Post

#### Request Body
```json
{
    "post_id": 1,
    "action": "unlike"
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Student post unliked successfully",
    "data": {
        "post_id": 1,
        "is_liked_by_user": false,
        "likes_count": 0
    }
}
```

## ❌ Error Handling Examples

### Invalid Post ID (404)

#### Request Body
```json
{
    "post_id": 99999,
    "action": "like"
}
```

#### Error Response
```json
{
    "status": "error",
    "message": "Post not found or user not authorized",
    "data": null
}
```

### Invalid Action Parameter (422)

#### Request Body
```json
{
    "post_id": 1,
    "action": "invalid_action"
}
```

#### Error Response
```json
{
    "status": "error",
    "message": "Validation failed: The selected action is invalid.",
    "data": null
}
```

### Missing Required Fields (422)

#### Request Body
```json
{
    "post_id": 1
}
```

#### Error Response
```json
{
    "status": "error",
    "message": "Validation failed: The action field is required.",
    "data": null
}
```

### Authentication Error (401)

#### Missing Authorization Header
```json
{
    "status": "error",
    "message": "Unauthenticated",
    "data": null
}
```

### Server Error (500)

#### Example Response
```json
{
    "status": "error",
    "message": "Internal server error occurred",
    "data": null
}
```

## 📦 Postman Collection Setup

### 1. Create New Collection
- Name: `Activity Feed Management APIs`
- Description: `Toggle-like functionality for school, class, and student posts`

### 2. Environment Setup
Create a new environment with these variables:

```json
{
    "BASE_URL": "http://localhost:8000",
    "API_PREFIX": "/api/activity-feed-management",
    "TOKEN": "your_auth_token_here",
    "SCHOOL_POST_ID": "1",
    "CLASS_POST_ID": "1", 
    "STUDENT_POST_ID": "1"
}
```

### 3. Collection Variables
Add these to your collection:

```json
{
    "baseUrl": "{{BASE_URL}}{{API_PREFIX}}",
    "authToken": "{{TOKEN}}"
}
```

### 4. Pre-request Script (Collection Level)
```javascript
// Set common headers for all requests
pm.request.headers.add({
    key: 'Authorization',
    value: 'Bearer ' + pm.environment.get('TOKEN')
});

pm.request.headers.add({
    key: 'Content-Type',
    value: 'application/json'
});

pm.request.headers.add({
    key: 'Accept',
    value: 'application/json'
});
```

### 5. Test Script Examples

#### For Like Requests
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Response has correct structure", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData).to.have.property('status');
    pm.expect(jsonData).to.have.property('message');
    pm.expect(jsonData).to.have.property('data');
});

pm.test("Post is liked", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.data.is_liked_by_user).to.be.true;
    pm.expect(jsonData.data.likes_count).to.be.above(0);
});

pm.test("Response message is correct", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.message).to.include("liked successfully");
});
```

#### For Unlike Requests
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Post is unliked", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.data.is_liked_by_user).to.be.false;
});

pm.test("Response message is correct", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.message).to.include("unliked successfully");
});
```

## 🧪 Testing Scenarios

### Scenario 1: Complete Like/Unlike Cycle

1. **Like a School Post**
   - Endpoint: `POST /school-posts/toggle-like`
   - Body: `{"post_id": 1, "action": "like"}`
   - Expected: `is_liked_by_user: true`, `likes_count: 1`

2. **Unlike the Same School Post**
   - Endpoint: `POST /school-posts/toggle-like`
   - Body: `{"post_id": 1, "action": "unlike"}`
   - Expected: `is_liked_by_user: false`, `likes_count: 0`

### Scenario 2: Cross-Post Type Testing

1. **Like Different Post Types**
   - Like School Post ID 1
   - Like Class Post ID 1  
   - Like Student Post ID 1
   - Verify each has independent like counts

### Scenario 3: Multiple Users Testing

1. **User A likes a post**
   - Use Token A
   - Like School Post ID 1
   - Verify: `likes_count: 1`

2. **User B likes the same post**
   - Use Token B
   - Like School Post ID 1
   - Verify: `likes_count: 2`

3. **User A unlikes the post**
   - Use Token A
   - Unlike School Post ID 1
   - Verify: `likes_count: 1`

### Scenario 4: Error Validation Testing

1. **Test Invalid Post IDs**
   - Try: `{"post_id": 99999, "action": "like"}`
   - Expected: 404 error

2. **Test Invalid Actions**
   - Try: `{"post_id": 1, "action": "favorite"}`
   - Expected: 422 validation error

3. **Test Missing Fields**
   - Try: `{"post_id": 1}`
   - Expected: 422 validation error

4. **Test Unauthorized Access**
   - Remove Authorization header
   - Expected: 401 authentication error

### Scenario 5: Duplicate Like Prevention

1. **Like a post**
   - Request: `{"post_id": 1, "action": "like"}`
   - Expected: Success

2. **Try to like the same post again**
   - Request: `{"post_id": 1, "action": "like"}`
   - Expected: Still shows as liked (no duplicate)

## 📊 Performance Testing

### Load Testing Parameters
- **Concurrent Users**: 10-50
- **Request Rate**: 100 requests/minute
- **Duration**: 5 minutes
- **Endpoints**: All three toggle-like APIs

### Expected Performance
- **Response Time**: < 200ms
- **Success Rate**: > 99%
- **Error Rate**: < 1%

## 🔧 Troubleshooting

### Common Issues

1. **401 Unauthorized**
   - Check if Authorization header is set
   - Verify token validity
   - Ensure AuthGuard middleware is working

2. **404 Not Found**
   - Verify post ID exists in database
   - Check if post is active
   - Confirm API route is correct

3. **422 Validation Error**
   - Check required fields (post_id, action)
   - Verify action is either "like" or "unlike"
   - Ensure post_id is a valid integer

4. **500 Server Error**
   - Check database connection
   - Verify all related tables exist
   - Check application logs

### Debugging Tips

1. **Enable Laravel Debug Mode**
   - Set `APP_DEBUG=true` in `.env`
   - Check detailed error messages

2. **Check Database Tables**
   - Verify all post tables exist: `school_posts`, `class_posts`, `student_posts`
   - Verify all like tables exist: `school_post_likes`, `class_post_likes`, `student_post_likes`

3. **Monitor Database Queries**
   - Use Laravel Query Log
   - Check for constraint violations

## 📝 Notes

- All APIs use the same request/response structure for consistency
- Likes are user-specific and post-specific (no global likes)
- Each post type has its own dedicated like table
- Duplicate likes are prevented by unique constraints
- All operations are atomic using database transactions