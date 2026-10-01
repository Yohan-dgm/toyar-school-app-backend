# Complete Activity Feed Management API Testing Guide

This comprehensive guide covers ALL 18 routes in the Activity Feed Management module with detailed Postman testing examples.

## 📋 Table of Contents

1. [Authentication & Environment Setup](#authentication--environment-setup)
2. [School Posts APIs](#school-posts-apis)
3. [Class Posts APIs](#class-posts-apis)
4. [Student Posts APIs](#student-posts-apis)
5. [Storage APIs](#storage-apis)
6. [Error Handling](#error-handling)
7. [Postman Collection Setup](#postman-collection-setup)
8. [Testing Workflows](#testing-workflows)

## 🔐 Authentication & Environment Setup

### Base Configuration
```
BASE_URL: http://localhost:8000
API_PREFIX: /api/activity-feed-management
TOKEN: your_auth_token_here
```

### Required Headers (All Routes)
```
Authorization: Bearer {{TOKEN}}
Content-Type: application/json
Accept: application/json
```

---

## 🏫 School Posts APIs

### 1. Create School Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/school-posts/create
```

#### Request Body
```json
{
    "type": "announcement",
    "category": "News",
    "title": "Welcome Back to School!",
    "content": "We are excited to welcome all students back for the new academic year. Please review the updated safety protocols and academic calendar.",
    "author_id": 1,
    "school_id": 1,
    "hashtags": ["Welcome", "NewYear", "Safety"],
    "media": [
        {
            "type": "image",
            "url": "/storage/school-posts/welcome-banner.jpg",
            "filename": "welcome-banner.jpg",
            "size": 245760,
            "sort_order": 1
        }
    ]
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "School post created successfully",
    "data": {
        "id": 1,
        "type": "announcement",
        "category": "News",
        "title": "Welcome Back to School!",
        "content": "We are excited to welcome all students back...",
        "author_id": 1,
        "school_id": 1,
        "likes_count": 0,
        "comments_count": 0,
        "is_active": true,
        "created_at": "2025-01-15T10:30:00.000000Z",
        "updated_at": "2025-01-15T10:30:00.000000Z",
        "author": {
            "id": 1,
            "name": "John Administrator",
            "email": "admin@school.edu"
        },
        "hashtags": [
            {"id": 1, "hashtag": "Welcome"},
            {"id": 2, "hashtag": "NewYear"},
            {"id": 3, "hashtag": "Safety"}
        ],
        "media": [
            {
                "id": 1,
                "type": "image",
                "url": "/storage/school-posts/welcome-banner.jpg",
                "filename": "welcome-banner.jpg",
                "size": 245760,
                "sort_order": 1
            }
        ]
    }
}
```

### 2. Get School Posts List

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/school-posts/list
```

#### Request Body (with filters)
```json
{
    "school_id": 1,
    "type": "announcement",
    "category": "News",
    "search": "welcome",
    "hashtags": ["Welcome", "NewYear"],
    "date_from": "2025-01-01",
    "date_to": "2025-12-31",
    "page": 1,
    "per_page": 10,
    "sort_by": "created_at",
    "sort_order": "desc"
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "School posts retrieved successfully",
    "data": {
        "posts": [
            {
                "id": 1,
                "type": "announcement",
                "category": "News",
                "title": "Welcome Back to School!",
                "content": "We are excited to welcome all students back...",
                "author_id": 1,
                "school_id": 1,
                "likes_count": 5,
                "comments_count": 2,
                "is_active": true,
                "created_at": "2025-01-15T10:30:00.000000Z",
                "updated_at": "2025-01-15T10:30:00.000000Z",
                "author": {
                    "id": 1,
                    "name": "John Administrator"
                },
                "hashtags": ["Welcome", "NewYear", "Safety"],
                "media_count": 1,
                "is_liked_by_user": false
            }
        ],
        "pagination": {
            "current_page": 1,
            "per_page": 10,
            "total": 1,
            "last_page": 1,
            "from": 1,
            "to": 1
        }
    }
}
```

### 3. Update School Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/school-posts/update
```

#### Request Body
```json
{
    "id": 1,
    "title": "Updated: Welcome Back to School!",
    "content": "We are excited to welcome all students back for the new academic year. Updated content with new information.",
    "category": "Important News",
    "hashtags": ["Welcome", "NewYear", "Safety", "Updated"],
    "add_media": [
        {
            "type": "pdf",
            "url": "/storage/school-posts/safety-guidelines.pdf",
            "filename": "safety-guidelines.pdf",
            "size": 524288,
            "sort_order": 2
        }
    ],
    "remove_media_ids": []
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "School post updated successfully",
    "data": {
        "id": 1,
        "type": "announcement",
        "category": "Important News",
        "title": "Updated: Welcome Back to School!",
        "content": "We are excited to welcome all students back...",
        "author_id": 1,
        "school_id": 1,
        "likes_count": 5,
        "comments_count": 2,
        "is_active": true,
        "updated_at": "2025-01-15T14:20:00.000000Z",
        "hashtags": ["Welcome", "NewYear", "Safety", "Updated"],
        "media": [
            {
                "id": 1,
                "type": "image",
                "filename": "welcome-banner.jpg",
                "sort_order": 1
            },
            {
                "id": 2,
                "type": "pdf",
                "filename": "safety-guidelines.pdf",
                "sort_order": 2
            }
        ]
    }
}
```

### 4. Delete School Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/school-posts/delete
```

#### Request Body
```json
{
    "id": 1
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "School post deleted successfully",
    "data": {
        "id": 1,
        "deleted_at": "2025-01-15T16:45:00.000000Z"
    }
}
```

### 5. Toggle Like School Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/school-posts/toggle-like
```

#### Like Request Body
```json
{
    "post_id": 1,
    "action": "like"
}
```

#### Unlike Request Body
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
    "message": "Post liked successfully",
    "data": {
        "post_id": 1,
        "is_liked_by_user": true,
        "likes_count": 6
    }
}
```

---

## 🎓 Class Posts APIs

### 1. Create Class Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/class-posts/create
```

#### Request Body
```json
{
    "type": "assignment",
    "category": "Homework",
    "title": "Math Homework Due Tomorrow",
    "content": "Please complete Chapter 5 exercises 1-20. Show all your work and submit in the homework folder.",
    "author_id": 2,
    "school_id": 1,
    "class_id": 101,
    "hashtags": ["Math", "Homework", "Chapter5"],
    "media": [
        {
            "type": "pdf",
            "url": "/storage/class-posts/math-homework-ch5.pdf",
            "filename": "math-homework-ch5.pdf",
            "size": 156720,
            "sort_order": 1
        }
    ]
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Class post created successfully",
    "data": {
        "id": 1,
        "type": "assignment",
        "category": "Homework",
        "title": "Math Homework Due Tomorrow",
        "content": "Please complete Chapter 5 exercises 1-20...",
        "author_id": 2,
        "school_id": 1,
        "class_id": 101,
        "likes_count": 0,
        "comments_count": 0,
        "is_active": true,
        "created_at": "2025-01-15T09:15:00.000000Z",
        "updated_at": "2025-01-15T09:15:00.000000Z",
        "author": {
            "id": 2,
            "name": "Mrs. Johnson",
            "email": "johnson@school.edu"
        },
        "hashtags": [
            {"hashtag": "Math"},
            {"hashtag": "Homework"},
            {"hashtag": "Chapter5"}
        ],
        "media": [
            {
                "id": 1,
                "type": "pdf",
                "filename": "math-homework-ch5.pdf",
                "size": 156720
            }
        ]
    }
}
```

### 2. Get Class Posts List

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/class-posts/list
```

#### Request Body
```json
{
    "school_id": 1,
    "class_id": 101,
    "type": "assignment",
    "category": "Homework",
    "search": "math",
    "author_id": 2,
    "date_from": "2025-01-01",
    "date_to": "2025-01-31",
    "page": 1,
    "per_page": 20,
    "sort_by": "created_at",
    "sort_order": "desc"
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Class posts retrieved successfully",
    "data": {
        "posts": [
            {
                "id": 1,
                "type": "assignment",
                "category": "Homework",
                "title": "Math Homework Due Tomorrow",
                "content": "Please complete Chapter 5 exercises...",
                "author_id": 2,
                "school_id": 1,
                "class_id": 101,
                "likes_count": 3,
                "comments_count": 1,
                "is_active": true,
                "created_at": "2025-01-15T09:15:00.000000Z",
                "author": {
                    "name": "Mrs. Johnson"
                },
                "hashtags": ["Math", "Homework"],
                "is_liked_by_user": false
            }
        ],
        "pagination": {
            "current_page": 1,
            "total": 1,
            "per_page": 20
        }
    }
}
```

### 3. Update Class Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/class-posts/update
```

#### Request Body
```json
{
    "id": 1,
    "title": "Math Homework Extended Deadline",
    "content": "Deadline extended to Friday. Please complete Chapter 5 exercises 1-20 and the bonus problem on page 156.",
    "category": "Extended Homework",
    "hashtags": ["Math", "Homework", "Extended", "Chapter5"]
}
```

### 4. Delete Class Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/class-posts/delete
```

#### Request Body
```json
{
    "id": 1
}
```

### 5. Toggle Like Class Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/class-posts/toggle-like
```

#### Request Body
```json
{
    "post_id": 1,
    "action": "like"
}
```

---

## 👨‍🎓 Student Posts APIs

### 1. Create Student Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/student-posts/create
```

#### Request Body
```json
{
    "type": "achievement",
    "category": "Academic",
    "title": "Won Math Competition!",
    "content": "I'm excited to share that I won first place in the inter-school math competition! Thanks to everyone who supported me.",
    "author_id": 15,
    "school_id": 1,
    "class_id": 101,
    "student_id": 15,
    "hashtags": ["Achievement", "Math", "Competition", "FirstPlace"],
    "media": [
        {
            "type": "image",
            "url": "/storage/student-posts/math-trophy.jpg",
            "filename": "math-trophy.jpg",
            "size": 198432,
            "sort_order": 1
        }
    ]
}
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Student post created successfully",
    "data": {
        "id": 1,
        "type": "achievement",
        "category": "Academic",
        "title": "Won Math Competition!",
        "content": "I'm excited to share that I won first place...",
        "author_id": 15,
        "school_id": 1,
        "class_id": 101,
        "student_id": 15,
        "likes_count": 0,
        "comments_count": 0,
        "is_active": true,
        "created_at": "2025-01-15T14:30:00.000000Z",
        "updated_at": "2025-01-15T14:30:00.000000Z",
        "author": {
            "id": 15,
            "name": "Alex Thompson",
            "email": "alex.thompson@student.edu"
        },
        "hashtags": [
            {"hashtag": "Achievement"},
            {"hashtag": "Math"},
            {"hashtag": "Competition"},
            {"hashtag": "FirstPlace"}
        ],
        "media": [
            {
                "id": 1,
                "type": "image",
                "filename": "math-trophy.jpg"
            }
        ]
    }
}
```

### 2. Get Student Posts List

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/student-posts/list
```

#### Request Body
```json
{
    "school_id": 1,
    "class_id": 101,
    "student_id": 15,
    "type": "achievement",
    "category": "Academic",
    "search": "math",
    "hashtags": ["Achievement", "Math"],
    "date_from": "2025-01-01",
    "page": 1,
    "per_page": 10
}
```

### 3. Update Student Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/student-posts/update
```

#### Request Body
```json
{
    "id": 1,
    "title": "Won Math Competition - Update!",
    "content": "I won first place in the inter-school math competition! The ceremony will be held next week. Thank you for all the support!",
    "hashtags": ["Achievement", "Math", "Competition", "FirstPlace", "Ceremony"]
}
```

### 4. Delete Student Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/student-posts/delete
```

#### Request Body
```json
{
    "id": 1
}
```

### 5. Toggle Like Student Post

#### Endpoint
```
POST {{BASE_URL}}{{API_PREFIX}}/student-posts/toggle-like
```

#### Request Body
```json
{
    "post_id": 1,
    "action": "like"
}
```

---

## 📁 Storage APIs

### 1. List Directory Contents

#### Endpoint
```
GET {{BASE_URL}}{{API_PREFIX}}/storage/list/activity-feed-posts
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "Directory contents retrieved successfully",
    "data": {
        "directory": "activity-feed-posts",
        "files": [
            {
                "name": "welcome-banner.jpg",
                "type": "image",
                "size": 245760,
                "modified": "2025-01-15T10:30:00.000000Z",
                "path": "activity-feed-posts/welcome-banner.jpg"
            },
            {
                "name": "math-homework-ch5.pdf",
                "type": "pdf",
                "size": 156720,
                "modified": "2025-01-15T09:15:00.000000Z",
                "path": "activity-feed-posts/math-homework-ch5.pdf"
            }
        ],
        "total_files": 2,
        "total_size": 402480
    }
}
```

### 2. Get File

#### Endpoint
```
GET {{BASE_URL}}{{API_PREFIX}}/storage/file/activity-feed-posts/welcome-banner.jpg
```

#### Success Response
Returns the actual file content with appropriate headers:
```
Content-Type: image/jpeg
Content-Length: 245760
Content-Disposition: inline; filename="welcome-banner.jpg"
```

### 3. Get File Information

#### Endpoint
```
GET {{BASE_URL}}{{API_PREFIX}}/storage/info/activity-feed-posts/welcome-banner.jpg
```

#### Success Response (200)
```json
{
    "status": "successful",
    "message": "File information retrieved successfully",
    "data": {
        "filename": "welcome-banner.jpg",
        "original_name": "welcome-banner.jpg",
        "mime_type": "image/jpeg",
        "size": 245760,
        "size_human": "240.0 KB",
        "created_at": "2025-01-15T10:30:00.000000Z",
        "modified_at": "2025-01-15T10:30:00.000000Z",
        "path": "activity-feed-posts/welcome-banner.jpg",
        "url": "/api/activity-feed-management/storage/file/activity-feed-posts/welcome-banner.jpg",
        "dimensions": {
            "width": 1920,
            "height": 1080
        }
    }
}
```

---

## ❌ Error Handling

### Authentication Errors

#### 401 Unauthorized
```json
{
    "status": "error",
    "message": "Unauthenticated",
    "data": null
}
```

### Validation Errors

#### 422 Validation Error
```json
{
    "status": "error",
    "message": "Validation failed",
    "data": {
        "errors": {
            "title": ["The title field is required."],
            "content": ["The content field is required."],
            "school_id": ["The school id field must be an integer."]
        }
    }
}
```

### Not Found Errors

#### 404 Post Not Found
```json
{
    "status": "error",
    "message": "Post not found or user not authorized",
    "data": null
}
```

#### 404 File Not Found
```json
{
    "status": "error",
    "message": "File not found",
    "data": null
}
```

### Server Errors

#### 500 Internal Server Error
```json
{
    "status": "error",
    "message": "Internal server error occurred",
    "data": null
}
```

---

## 📦 Postman Collection Setup

### Environment Variables
```json
{
    "BASE_URL": "http://localhost:8000",
    "API_PREFIX": "/api/activity-feed-management",
    "TOKEN": "your_auth_token_here",
    "SCHOOL_ID": "1",
    "CLASS_ID": "101",
    "STUDENT_ID": "15",
    "AUTHOR_ID": "1"
}
```

### Collection Pre-request Script
```javascript
// Set authentication header
pm.request.headers.add({
    key: 'Authorization',
    value: 'Bearer ' + pm.environment.get('TOKEN')
});

// Set content type for POST requests
if (pm.request.method === 'POST') {
    pm.request.headers.add({
        key: 'Content-Type',
        value: 'application/json'
    });
}

// Set accept header
pm.request.headers.add({
    key: 'Accept',
    value: 'application/json'
});
```

### Test Scripts for CRUD Operations

#### Create Post Test
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Post created successfully", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.status).to.eql("successful");
    pm.expect(jsonData.data).to.have.property("id");
    
    // Store created post ID for other tests
    pm.environment.set("CREATED_POST_ID", jsonData.data.id);
});

pm.test("Required fields are present", function () {
    const jsonData = pm.response.json();
    const post = jsonData.data;
    pm.expect(post).to.have.property("title");
    pm.expect(post).to.have.property("content");
    pm.expect(post).to.have.property("author_id");
    pm.expect(post.likes_count).to.eql(0);
});
```

#### List Posts Test
```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Posts list retrieved", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.data).to.have.property("posts");
    pm.expect(jsonData.data).to.have.property("pagination");
});

pm.test("Pagination structure is correct", function () {
    const jsonData = pm.response.json();
    const pagination = jsonData.data.pagination;
    pm.expect(pagination).to.have.property("current_page");
    pm.expect(pagination).to.have.property("total");
    pm.expect(pagination).to.have.property("per_page");
});
```

#### Update Post Test
```javascript
pm.test("Post updated successfully", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.status).to.eql("successful");
    pm.expect(jsonData.message).to.include("updated successfully");
});
```

#### Delete Post Test
```javascript
pm.test("Post deleted successfully", function () {
    const jsonData = pm.response.json();
    pm.expect(jsonData.status).to.eql("successful");
    pm.expect(jsonData.message).to.include("deleted successfully");
});
```

---

## 🧪 Testing Workflows

### Complete CRUD Workflow

1. **Create a School Post**
   - Use create endpoint with full data
   - Store returned post ID

2. **List Posts to Verify Creation**
   - Use list endpoint with filters
   - Verify new post appears

3. **Update the Post**
   - Modify title and add hashtag
   - Verify changes are applied

4. **Like the Post**
   - Use toggle-like with "like" action
   - Verify likes_count increases

5. **Unlike the Post**
   - Use toggle-like with "unlike" action
   - Verify likes_count decreases

6. **Delete the Post**
   - Use delete endpoint
   - Verify post is removed

### Cross-Post Type Testing

1. **Create posts of each type**
   - School post with school_id
   - Class post with school_id + class_id
   - Student post with school_id + class_id + student_id

2. **Verify independent like systems**
   - Like each post type
   - Confirm separate like counts

3. **Test filtering by type**
   - List posts with type filters
   - Verify correct posts returned

### Media Upload Testing

1. **Create post with media**
   - Include image and PDF files
   - Verify media associations

2. **Update post media**
   - Add new media files
   - Remove existing media
   - Verify changes applied

3. **Test storage endpoints**
   - List directory contents
   - Get file information
   - Download files

### Performance Testing

1. **Bulk operations**
   - Create 50 posts rapidly
   - Measure response times

2. **Pagination testing**
   - Request different page sizes
   - Verify pagination accuracy

3. **Search and filter performance**
   - Test complex filter combinations
   - Measure query execution time

This comprehensive guide covers all 18 API endpoints with real-world examples, complete request/response formats, and production-ready testing scenarios.