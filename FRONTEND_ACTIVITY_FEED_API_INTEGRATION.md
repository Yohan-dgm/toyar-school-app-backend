# Frontend Activity Feed API Integration Guide

This document provides comprehensive guidance for frontend developers to integrate with the Activity Feed Management APIs for creating posts with media upload functionality.

## Table of Contents

1. [API Endpoints Overview](#api-endpoints-overview)
2. [Authentication Requirements](#authentication-requirements)
3. [Post Creation Methods](#post-creation-methods)
4. [Media Upload Options](#media-upload-options)
5. [Request Format Examples](#request-format-examples)
6. [Response Format Documentation](#response-format-documentation)
7. [File Validation Rules](#file-validation-rules)
8. [Error Handling](#error-handling)
9. [Best Practices](#best-practices)
10. [Testing Examples](#testing-examples)

## API Endpoints Overview

All Activity Feed Management APIs are prefixed with `/api/activity-feed-management/` and require authentication.

### Post Creation Endpoints

| Post Type | Endpoint | Method | Purpose |
|-----------|----------|--------|---------|
| School Posts | `/api/activity-feed-management/school-posts/create` | POST | Create school-wide announcements and posts |
| Class Posts | `/api/activity-feed-management/class-posts/create` | POST | Create class-specific posts and assignments |
| Student Posts | `/api/activity-feed-management/student-posts/create` | POST | Create student achievement and project posts |

### Media Upload Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/activity-feed-management/media/upload` | POST | Standalone media upload (before post creation) |
| `/api/activity-feed-management/storage/file/{path}` | GET | Serve uploaded media files |
| `/api/activity-feed-management/storage/info/{path}` | GET | Get media file information |

### Additional Endpoints

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/activity-feed-management/{post-type}/list` | POST | Get list of posts |
| `/api/activity-feed-management/{post-type}/update` | POST | Update existing posts |
| `/api/activity-feed-management/{post-type}/delete` | POST | Delete posts |
| `/api/activity-feed-management/{post-type}/toggle-like` | POST | Like/unlike posts |

## Authentication Requirements

All endpoints require the `AuthGuard` middleware. Include the authentication token in your requests:

```javascript
headers: {
  'Authorization': 'Bearer your-auth-token',
  'Accept': 'application/json'
}
```

The user ID is automatically extracted from the authenticated user session.

## Post Creation Methods

### Method 1: Direct Post Creation with Media (Recommended)

Upload media files directly when creating a post using FormData.

**Advantages:**
- Single API call
- Automatic media association with post
- Atomic operation (all or nothing)

### Method 2: Standalone Media Upload + Post Creation

First upload media files, then create post with media references.

**Advantages:**
- Better progress tracking for large files
- Ability to preview uploaded media before post creation
- Can reuse uploaded media across posts

## Media Upload Options

### Supported File Types

| Type | Extensions | MIME Types | Max Size |
|------|------------|------------|----------|
| Images | jpg, jpeg, png, webp | image/jpeg, image/png, image/webp | 50MB |
| Videos | mp4, mov, avi | video/mp4, video/quicktime, video/x-msvideo | 50MB |
| Documents | pdf | application/pdf | 50MB |

### File Processing

- **Images**: Auto-resized to max 1920px dimension, converted to JPEG for consistency
- **Videos**: Thumbnails generated at 3-second mark using FFmpeg
- **Thumbnails**: 300x300px JPEG format for all media types
- **Storage**: Organized by post type and media type in structured directories

### Limits

- **Max files per post**: 10
- **Max file size**: 50MB per file
- **Max total upload**: 500MB per post

## Request Format Examples

### 1. Create School Post with Media (FormData)

```javascript
const formData = new FormData();

// Required fields
formData.append('title', 'Welcome Back to School!');
formData.append('content', 'We are excited to welcome all students back for the new academic year. #newyear #welcome');

// Optional fields
formData.append('type', 'announcement');
formData.append('category', 'News');
formData.append('school_id', '1');

// Media files (indexed approach)
formData.append('media_count', files.length);
files.forEach((file, index) => {
  formData.append(`media_${index}`, file);
});

// Alternative: Array approach
files.forEach(file => {
  formData.append('media[]', file);
});

// Hashtags (optional - auto-extracted from content)
formData.append('hashtags[]', 'announcement');
formData.append('hashtags[]', 'important');

const response = await fetch('/api/activity-feed-management/school-posts/create', {
  method: 'POST',
  headers: {
    'Authorization': `Bearer ${authToken}`,
  },
  body: formData
});
```

### 2. Create Class Post with Media

```javascript
const createClassPost = async (postData, files) => {
  const formData = new FormData();
  
  // Required fields
  formData.append('title', postData.title);
  formData.append('content', postData.content);
  formData.append('class_id', postData.classId);
  
  // Optional fields
  formData.append('type', postData.type || 'post');
  formData.append('category', postData.category || '');
  
  // Media files
  if (files && files.length > 0) {
    formData.append('media_count', files.length);
    files.forEach((file, index) => {
      formData.append(`media_${index}`, file);
    });
  }
  
  try {
    const response = await fetch('/api/activity-feed-management/class-posts/create', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${getAuthToken()}`,
      },
      body: formData
    });
    
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}: ${response.statusText}`);
    }
    
    return await response.json();
  } catch (error) {
    console.error('Failed to create class post:', error);
    throw error;
  }
};
```

### 3. Create Student Post with Media

```javascript
const createStudentPost = async (achievementData, mediaFiles) => {
  const formData = new FormData();
  
  // Required fields
  formData.append('title', achievementData.title);
  formData.append('content', achievementData.description);
  formData.append('student_id', achievementData.studentId);
  formData.append('class_id', achievementData.classId);
  
  // Achievement-specific fields
  formData.append('type', 'achievement');
  formData.append('category', achievementData.category); // 'Academic', 'Sports', 'Arts', etc.
  
  // Media files
  if (mediaFiles && mediaFiles.length > 0) {
    formData.append('media_count', mediaFiles.length);
    mediaFiles.forEach((file, index) => {
      formData.append(`media_${index}`, file);
    });
  }
  
  const response = await fetch('/api/activity-feed-management/student-posts/create', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${authToken}`,
    },
    body: formData
  });
  
  return await response.json();
};
```

### 4. Standalone Media Upload

```javascript
const uploadMediaFiles = async (files, postType) => {
  const formData = new FormData();
  
  // Specify post type for proper storage organization
  formData.append('post_type', postType); // 'school-posts', 'class-posts', 'student-posts'
  
  // Add files with indexed naming
  files.forEach((file, index) => {
    formData.append(`file_${index}`, file);
  });
  
  try {
    const response = await fetch('/api/activity-feed-management/media/upload', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${authToken}`,
      },
      body: formData
    });
    
    if (!response.ok) {
      throw new Error(`Upload failed: ${response.statusText}`);
    }
    
    const result = await response.json();
    return result.data.uploaded_files; // Array of uploaded file metadata
  } catch (error) {
    console.error('Media upload failed:', error);
    throw error;
  }
};

// Then create post with uploaded media references
const createPostWithUploadedMedia = async (postData, uploadedMedia) => {
  const formData = new FormData();
  
  formData.append('title', postData.title);
  formData.append('content', postData.content);
  
  // Include uploaded media metadata
  formData.append('media', JSON.stringify(uploadedMedia));
  
  const response = await fetch('/api/activity-feed-management/school-posts/create', {
    method: 'POST',
    headers: {
      'Authorization': `Bearer ${authToken}`,
      'Content-Type': 'application/json'
    },
    body: formData
  });
  
  return await response.json();
};
```

## Response Format Documentation

### Successful Post Creation Response

```json
{
  "success": true,
  "message": "Post created successfully",
  "data": {
    "id": 123,
    "type": "announcement",
    "category": "News",
    "title": "Welcome Back to School!",
    "content": "We are excited to welcome all students back...",
    "author_id": 1,
    "school_id": 1,
    "class_id": null,
    "student_id": null,
    "likes_count": 0,
    "comments_count": 0,
    "is_active": true,
    "created_at": "2024-12-16T10:30:00Z",
    "updated_at": "2024-12-16T10:30:00Z",
    "author": {
      "id": 1,
      "username": "admin",
      "email": "admin@school.com"
    },
    "media": [
      {
        "id": 456,
        "post_id": 123,
        "type": "image",
        "url": "/storage/nexis-college/yakkala/school-posts/images/post-123-user-1-1671187800-abc12345.jpg",
        "thumbnail_url": "/storage/nexis-college/yakkala/school-posts/thumbnails/thumb-post-123-user-1-1671187800-abc12345.jpg",
        "filename": "post-123-user-1-1671187800-abc12345.jpg",
        "original_filename": "school-event.jpg",
        "size": 245760,
        "mime_type": "image/jpeg",
        "width": 1920,
        "height": 1080,
        "duration": null,
        "sort_order": 1,
        "is_active": true,
        "created_at": "2024-12-16T10:30:00Z"
      }
    ],
    "hashtags": [
      {
        "id": 789,
        "post_id": 123,
        "hashtag": "newYear",
        "is_active": true,
        "created_at": "2024-12-16T10:30:00Z"
      },
      {
        "id": 790,
        "post_id": 123,
        "hashtag": "welcome",
        "is_active": true,
        "created_at": "2024-12-16T10:30:00Z"
      }
    ]
  }
}
```

### Successful Media Upload Response

```json
{
  "success": true,
  "message": "Files uploaded successfully",
  "data": {
    "uploaded_files": [
      {
        "type": "image",
        "url": "/storage/nexis-college/yakkala/temp-uploads/images/temp-1-1671187800-987654321-def67890.jpg",
        "thumbnail_url": "/storage/nexis-college/yakkala/temp-uploads/thumbnails/thumb-temp-1-1671187800-987654321-def67890.jpg",
        "filename": "temp-1-1671187800-987654321-def67890.jpg",
        "original_filename": "my-photo.jpg",
        "size": 156432,
        "mime_type": "image/jpeg",
        "width": 1920,
        "height": 1280,
        "duration": null,
        "storage_path": "nexis-college/yakkala/temp-uploads/images/temp-1-1671187800-987654321-def67890.jpg",
        "is_temp": true,
        "uploaded_at": "2024-12-16T10:25:00.000Z"
      }
    ],
    "upload_summary": {
      "total_files": 1,
      "successful_uploads": 1,
      "failed_uploads": 0,
      "total_size": 156432
    }
  }
}
```

## File Validation Rules

### Frontend Validation (Recommended)

```javascript
const validateFiles = (files) => {
  const errors = [];
  const maxSize = 50 * 1024 * 1024; // 50MB
  const maxFiles = 10;
  const allowedTypes = [
    'image/jpeg', 'image/jpg', 'image/png', 'image/webp',
    'video/mp4', 'video/quicktime', 'video/x-msvideo',
    'application/pdf'
  ];
  const allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'mp4', 'mov', 'avi', 'pdf'];

  if (files.length > maxFiles) {
    errors.push(`Maximum ${maxFiles} files allowed`);
  }

  files.forEach((file, index) => {
    // Size validation
    if (file.size > maxSize) {
      errors.push(`File ${index + 1}: Size exceeds 50MB limit`);
    }

    // Type validation
    if (!allowedTypes.includes(file.type)) {
      errors.push(`File ${index + 1}: File type not allowed`);
    }

    // Extension validation
    const extension = file.name.split('.').pop().toLowerCase();
    if (!allowedExtensions.includes(extension)) {
      errors.push(`File ${index + 1}: File extension not allowed`);
    }
  });

  return {
    isValid: errors.length === 0,
    errors
  };
};
```

### Backend Validation

The backend performs additional validation:

- **MIME type verification**: Checks actual file MIME type
- **File integrity**: Validates file is not corrupted
- **Security scanning**: Basic malware detection
- **Storage space**: Checks available storage

## Error Handling

### Common Error Responses

#### Validation Errors (422)

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "title": ["The title field is required."],
    "media_0": ["The file must be an image, video, or PDF."],
    "media_count": ["Media count cannot exceed 10 files."]
  }
}
```

#### Authentication Errors (401)

```json
{
  "success": false,
  "message": "Unauthorized",
  "error": "Authentication required"
}
```

#### File Upload Errors (400)

```json
{
  "success": false,
  "message": "File upload failed",
  "error": "File size too large. Maximum allowed size is 50MB.",
  "details": {
    "failed_files": [
      {
        "filename": "large-video.mp4",
        "error": "File size exceeds maximum limit"
      }
    ]
  }
}
```

#### Server Errors (500)

```json
{
  "success": false,
  "message": "Internal server error",
  "error": "An unexpected error occurred. Please try again."
}
```

### Error Handling Best Practices

```javascript
const handleApiError = (error, response) => {
  if (response) {
    switch (response.status) {
      case 401:
        // Redirect to login
        window.location.href = '/login';
        break;
      
      case 422:
        // Show validation errors
        const errors = response.data.errors;
        Object.keys(errors).forEach(field => {
          showFieldError(field, errors[field][0]);
        });
        break;
      
      case 413:
        showError('File too large. Please choose a smaller file.');
        break;
      
      case 429:
        showError('Too many requests. Please wait and try again.');
        break;
      
      default:
        showError('An error occurred. Please try again.');
    }
  } else {
    showError('Network error. Please check your connection.');
  }
};
```

## Best Practices

### 1. File Upload UX

```javascript
// Show upload progress
const uploadWithProgress = async (formData, onProgress) => {
  return new Promise((resolve, reject) => {
    const xhr = new XMLHttpRequest();
    
    xhr.upload.addEventListener('progress', (e) => {
      if (e.lengthComputable) {
        const percentComplete = (e.loaded / e.total) * 100;
        onProgress(percentComplete);
      }
    });
    
    xhr.addEventListener('load', () => {
      if (xhr.status === 200) {
        resolve(JSON.parse(xhr.responseText));
      } else {
        reject(new Error(`Upload failed: ${xhr.statusText}`));
      }
    });
    
    xhr.addEventListener('error', () => reject(new Error('Upload failed')));
    
    xhr.open('POST', '/api/activity-feed-management/school-posts/create');
    xhr.setRequestHeader('Authorization', `Bearer ${authToken}`);
    xhr.send(formData);
  });
};
```

### 2. Image Preview and Compression

```javascript
// Compress images before upload
const compressImage = (file, maxWidth = 1920, quality = 0.8) => {
  return new Promise((resolve) => {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const img = new Image();
    
    img.onload = () => {
      const ratio = Math.min(maxWidth / img.width, maxWidth / img.height);
      canvas.width = img.width * ratio;
      canvas.height = img.height * ratio;
      
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
      
      canvas.toBlob(resolve, 'image/jpeg', quality);
    };
    
    img.src = URL.createObjectURL(file);
  });
};
```

### 3. Retry Logic

```javascript
const uploadWithRetry = async (formData, maxRetries = 3) => {
  for (let attempt = 1; attempt <= maxRetries; attempt++) {
    try {
      const response = await fetch('/api/activity-feed-management/school-posts/create', {
        method: 'POST',
        headers: { 'Authorization': `Bearer ${authToken}` },
        body: formData
      });
      
      if (response.ok) {
        return await response.json();
      }
      
      if (response.status < 500 || attempt === maxRetries) {
        throw new Error(`HTTP ${response.status}: ${response.statusText}`);
      }
      
      // Wait before retry (exponential backoff)
      await new Promise(resolve => setTimeout(resolve, Math.pow(2, attempt) * 1000));
      
    } catch (error) {
      if (attempt === maxRetries) {
        throw error;
      }
    }
  }
};
```

### 4. Memory Management

```javascript
// Clean up object URLs to prevent memory leaks
const cleanupPreviewUrls = (urls) => {
  urls.forEach(url => {
    if (url.startsWith('blob:')) {
      URL.revokeObjectURL(url);
    }
  });
};

// Use this after showing file previews
useEffect(() => {
  return () => {
    cleanupPreviewUrls(previewUrls);
  };
}, [previewUrls]);
```

## Testing Examples

### Postman Collection

#### Create School Post with Media

```
POST {{base_url}}/api/activity-feed-management/school-posts/create
Authorization: Bearer {{auth_token}}
Content-Type: multipart/form-data

Body (form-data):
- title: "School Sports Day 2024"
- content: "Join us for our annual sports day celebration! #sportsday #school"
- type: "event"
- category: "Sports"
- media_count: 2
- media_0: [FILE] sports-poster.jpg
- media_1: [FILE] sports-video.mp4
```

#### Standalone Media Upload

```
POST {{base_url}}/api/activity-feed-management/media/upload
Authorization: Bearer {{auth_token}}
Content-Type: multipart/form-data

Body (form-data):
- post_type: "school-posts"
- file_0: [FILE] image1.jpg
- file_1: [FILE] document.pdf
```

### cURL Examples

```bash
# Create class post with media
curl -X POST \
  'http://localhost:8000/api/activity-feed-management/class-posts/create' \
  -H 'Authorization: Bearer your-auth-token' \
  -F 'title=Math Assignment Due Tomorrow' \
  -F 'content=Please submit your algebra exercises by tomorrow. #homework #math' \
  -F 'type=assignment' \
  -F 'category=Assignment' \
  -F 'class_id=1' \
  -F 'media_count=1' \
  -F 'media_0=@homework-sheet.pdf'

# Standalone media upload
curl -X POST \
  'http://localhost:8000/api/activity-feed-management/media/upload' \
  -H 'Authorization: Bearer your-auth-token' \
  -F 'post_type=student-posts' \
  -F 'file_0=@achievement-photo.jpg'
```

### JavaScript Test Function

```javascript
const testPostCreation = async () => {
  const testFile = new File(['test content'], 'test.jpg', { type: 'image/jpeg' });
  
  const formData = new FormData();
  formData.append('title', 'Test Post');
  formData.append('content', 'This is a test post #test');
  formData.append('media_count', '1');
  formData.append('media_0', testFile);
  
  try {
    const response = await fetch('/api/activity-feed-management/school-posts/create', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${authToken}`,
      },
      body: formData
    });
    
    const result = await response.json();
    console.log('Test result:', result);
    
    if (result.success) {
      console.log('✅ Post created successfully');
      console.log('Post ID:', result.data.id);
      console.log('Media uploaded:', result.data.media.length);
    } else {
      console.log('❌ Test failed:', result.message);
    }
  } catch (error) {
    console.error('❌ Test error:', error);
  }
};
```

---

## Summary

This integration guide provides everything needed to implement Activity Feed post creation with media upload. Key points:

1. **Use FormData** for file uploads with proper field naming
2. **Validate files client-side** before upload for better UX
3. **Handle errors gracefully** with appropriate user feedback
4. **Implement progress tracking** for large file uploads
5. **Follow storage organization** by post type and media type
6. **Use authentication tokens** for all API calls

For additional support or questions, contact the backend development team or refer to the API logs for debugging specific upload issues.