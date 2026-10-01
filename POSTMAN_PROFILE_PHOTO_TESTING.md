# Upload User Profile Photo - Postman Testing Guide

This guide provides comprehensive instructions for testing the upload user profile photo API endpoint using Postman.

## 📋 API Endpoint Information

- **Method**: `POST`
- **Endpoint**: `/api/user-management/user-profile/upload-profile-photo`
- **Full URL**: `http://your-domain/api/user-management/user-profile/upload-profile-photo`
- **Authentication**: Required (Bearer Token)
- **Content-Type**: `multipart/form-data`

## 🔧 Prerequisites

### 1. Authentication Token
Before testing, you need to obtain a valid authentication token:

1. **Sign In First**: Use the sign-in endpoint to get a token
   ```
   POST /api/user-management/user/sign-in
   ```
   
2. **Request Body**:
   ```json
   {
     "username": "your_username",
     "password": "your_password"
   }
   ```

3. **Extract Token**: From the response, copy the `token` value for use in profile photo upload.

### 2. Test Images
Prepare test images with different specifications:

- ✅ **Valid Image**: JPEG/PNG/WebP, 100x100 to 2048x2048px, max 5MB
- ❌ **Invalid Format**: TXT, PDF, or other non-image files
- ❌ **Too Large**: Images over 5MB
- ❌ **Too Small**: Images smaller than 100x100px
- ❌ **Too Big**: Images larger than 2048x2048px

## 📝 Postman Collection Setup

### Collection Variables
Set up the following variables in your Postman collection:

| Variable | Value | Description |
|----------|-------|-------------|
| `base_url` | `http://your-domain` | Your application's base URL |
| `auth_token` | `your_bearer_token` | Authentication token from sign-in |
| `user_id` | `1` | ID of the user uploading the photo |

## 🧪 Test Cases

### Test Case 1: Successful Profile Photo Upload

**Setup:**
1. Method: `POST`
2. URL: `{{base_url}}/api/user-management/user-profile/upload-profile-photo`

**Headers:**
```
Authorization: Bearer {{auth_token}}
Content-Type: multipart/form-data
```

**Body (form-data):**
| Key | Type | Value |
|-----|------|-------|
| `profile_image` | File | Select a valid image file (JPEG/PNG/WebP, 100x100-2048x2048px, <5MB) |

**Expected Response (201 Created):**
```json
{
    "status": "successful",
    "message": "Profile image uploaded successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "file_path": "public/nexis-college/profile_images/user_1_20250827123456.jpg",
        "filename": "profile.jpg",
        "file_format": "jpg",
        "file_size": 245760,
        "file_size_formatted": "240.00 KB",
        "mime_type": "image/jpeg",
        "width": 500,
        "height": 500,
        "dimensions_string": "500x500",
        "is_active": true,
        "full_url": "/storage/nexis-college/profile_images/user_1_20250827123456.jpg",
        "public_path": "storage/nexis-college/profile_images/user_1_20250827123456.jpg",
        "created_at": "2025-08-27 12:34:56",
        "updated_at": "2025-08-27 12:34:56"
    },
    "metadata": {
        "user_id": 1,
        "upload_timestamp": "2025-08-27 12:34:56",
        "file_info": {
            "size_formatted": "240.00 KB",
            "dimensions": "500x500",
            "format": "JPG"
        }
    }
}
```

### Test Case 2: Authentication Required

**Setup:**
1. Method: `POST`
2. URL: `{{base_url}}/api/user-management/user-profile/upload-profile-photo`

**Headers:**
```
Content-Type: multipart/form-data
```
*Note: No Authorization header*

**Body (form-data):**
| Key | Type | Value |
|-----|------|-------|
| `profile_image` | File | Any image file |

**Expected Response (401 Unauthorized):**
```json
{
    "status": "failed",
    "message": "Unauthorized access",
    "data": null,
    "metadata": null
}
```

### Test Case 3: Missing Profile Image

**Setup:**
1. Method: `POST`
2. URL: `{{base_url}}/api/user-management/user-profile/upload-profile-photo`

**Headers:**
```
Authorization: Bearer {{auth_token}}
Content-Type: multipart/form-data
```

**Body (form-data):**
*No form fields*

**Expected Response (422 Validation Error):**
```json
{
    "status": "failed",
    "message": "Validation failed",
    "data": null,
    "metadata": null,
    "errors": {
        "profile_image": [
            "Profile image is required."
        ]
    }
}
```

### Test Case 4: Invalid File Format

**Setup:**
1. Method: `POST`
2. URL: `{{base_url}}/api/user-management/user-profile/upload-profile-photo`

**Headers:**
```
Authorization: Bearer {{auth_token}}
Content-Type: multipart/form-data
```

**Body (form-data):**
| Key | Type | Value |
|-----|------|-------|
| `profile_image` | File | Upload a .txt or .pdf file |

**Expected Response (422 Validation Error):**
```json
{
    "status": "failed",
    "message": "Validation failed",
    "data": null,
    "metadata": null,
    "errors": {
        "profile_image": [
            "The image must be a JPEG, JPG, PNG, or WebP file."
        ]
    }
}
```

### Test Case 5: File Too Large

**Setup:**
1. Method: `POST`
2. URL: `{{base_url}}/api/user-management/user-profile/upload-profile-photo`

**Headers:**
```
Authorization: Bearer {{auth_token}}
Content-Type: multipart/form-data
```

**Body (form-data):**
| Key | Type | Value |
|-----|------|-------|
| `profile_image` | File | Upload an image > 5MB |

**Expected Response (422 Validation Error):**
```json
{
    "status": "failed",
    "message": "Validation failed",
    "data": null,
    "metadata": null,
    "errors": {
        "profile_image": [
            "The image size cannot exceed 5MB."
        ]
    }
}
```

### Test Case 6: Invalid Dimensions

**Setup:**
1. Method: `POST`
2. URL: `{{base_url}}/api/user-management/user-profile/upload-profile-photo`

**Headers:**
```
Authorization: Bearer {{auth_token}}
Content-Type: multipart/form-data
```

**Body (form-data):**
| Key | Type | Value |
|-----|------|-------|
| `profile_image` | File | Upload an image < 100x100px or > 2048x2048px |

**Expected Response (422 Validation Error):**
```json
{
    "status": "failed",
    "message": "Validation failed",
    "data": null,
    "metadata": null,
    "errors": {
        "profile_image": [
            "The image dimensions must be between 100x100 and 2048x2048 pixels."
        ]
    }
}
```

### Test Case 7: Multiple Uploads (Previous Image Deactivation)

**Setup:**
1. First, upload a profile image successfully (Test Case 1)
2. Upload another profile image with the same user

**Expected Behavior:**
- The new image should be uploaded successfully
- Previous images for the same user should be deactivated (`is_active: false`)
- Only the latest image should have `is_active: true`

## 🔍 Response Validation Checklist

### ✅ Successful Upload Response Should Include:
- [ ] `status`: "successful"
- [ ] `message`: "Profile image uploaded successfully" 
- [ ] `data.id`: Numeric ID of the uploaded image
- [ ] `data.user_id`: ID of the authenticated user
- [ ] `data.file_path`: Storage path of the uploaded file
- [ ] `data.filename`: Original filename
- [ ] `data.file_format`: File extension (jpg, png, webp)
- [ ] `data.file_size`: File size in bytes
- [ ] `data.file_size_formatted`: Human-readable file size
- [ ] `data.mime_type`: MIME type of the uploaded file
- [ ] `data.width`: Image width in pixels
- [ ] `data.height`: Image height in pixels
- [ ] `data.dimensions_string`: Formatted dimensions (e.g., "500x500")
- [ ] `data.is_active`: true
- [ ] `data.full_url`: Complete URL to access the image
- [ ] `data.public_path`: Public path to the stored image
- [ ] `data.created_at`: Upload timestamp
- [ ] `data.updated_at`: Last update timestamp
- [ ] `metadata.user_id`: User ID confirmation
- [ ] `metadata.upload_timestamp`: Upload timestamp
- [ ] `metadata.file_info`: Additional file information

### ❌ Error Response Should Include:
- [ ] `status`: "failed"
- [ ] `message`: Descriptive error message
- [ ] `data`: null
- [ ] `metadata`: null
- [ ] `errors`: Validation errors (for 422 responses)

## 🛠 Postman Pre-request Script

Add this script to automatically set the authentication token:

```javascript
// Pre-request Script
pm.test("Set auth token if available", function () {
    const authToken = pm.collectionVariables.get("auth_token");
    if (authToken) {
        pm.request.headers.add({
            key: "Authorization",
            value: "Bearer " + authToken
        });
    }
});
```

## 🧩 Postman Tests Script

Add these tests to validate the response:

```javascript
// Tests Script
pm.test("Status code validation", function () {
    const expectedCodes = [200, 201, 401, 422, 500];
    pm.expect(expectedCodes).to.include(pm.response.code);
});

pm.test("Response has valid JSON structure", function () {
    pm.expect(pm.response.json()).to.have.property('status');
    pm.expect(pm.response.json()).to.have.property('message');
    pm.expect(pm.response.json()).to.have.property('data');
    pm.expect(pm.response.json()).to.have.property('metadata');
});

pm.test("Successful upload validation", function () {
    if (pm.response.code === 201) {
        const response = pm.response.json();
        pm.expect(response.status).to.eql("successful");
        pm.expect(response.data).to.have.property('id');
        pm.expect(response.data).to.have.property('file_path');
        pm.expect(response.data).to.have.property('full_url');
        pm.expect(response.data.is_active).to.be.true;
        
        // Store the uploaded image ID for cleanup if needed
        pm.collectionVariables.set("last_uploaded_image_id", response.data.id);
    }
});

pm.test("Validation error structure", function () {
    if (pm.response.code === 422) {
        const response = pm.response.json();
        pm.expect(response.status).to.eql("failed");
        pm.expect(response).to.have.property('errors');
        pm.expect(response.errors).to.be.an('object');
    }
});

pm.test("Unauthorized access validation", function () {
    if (pm.response.code === 401) {
        const response = pm.response.json();
        pm.expect(response.status).to.eql("failed");
        pm.expect(response.message).to.include("Unauthorized");
    }
});
```

## 📱 cURL Examples

### Successful Upload
```bash
curl -X POST \
  'http://your-domain/api/user-management/user-profile/upload-profile-photo' \
  -H 'Authorization: Bearer YOUR_AUTH_TOKEN' \
  -H 'Content-Type: multipart/form-data' \
  -F 'profile_image=@/path/to/your/image.jpg'
```

### With Verbose Output
```bash
curl -X POST \
  'http://your-domain/api/user-management/user-profile/upload-profile-photo' \
  -H 'Authorization: Bearer YOUR_AUTH_TOKEN' \
  -H 'Content-Type: multipart/form-data' \
  -F 'profile_image=@/path/to/your/image.jpg' \
  -v
```

## 🔧 Troubleshooting

### Common Issues and Solutions

1. **"Token not provided" Error**
   - Ensure the Authorization header is properly set
   - Check that the token is prefixed with "Bearer "

2. **"File not found" Error**
   - Verify the file path in the form-data
   - Ensure the file exists and is readable

3. **"Database connection" Error**
   - Check that the database is running
   - Verify database configuration in .env file

4. **"Storage directory not writable" Error**
   - Check file permissions for storage directory
   - Ensure the web server can write to the storage path

5. **"Route not found" Error**
   - Verify the API URL is correct
   - Check that the route is properly registered

### Debug Headers
Add these headers for debugging:
```
X-Debug: true
Accept: application/json
```

## 📊 File Size and Dimension Examples

### ✅ Valid Test Images
- **Small**: 150x150px, 50KB, JPEG
- **Medium**: 500x500px, 200KB, PNG  
- **Large**: 1920x1080px, 2MB, WebP
- **Max Size**: 2048x2048px, 4.9MB, JPEG

### ❌ Invalid Test Images
- **Too Small**: 50x50px (below 100x100 minimum)
- **Too Large Dimensions**: 3000x3000px (above 2048x2048 maximum)
- **Too Large File**: 6MB file (above 5MB maximum)
- **Wrong Format**: .gif, .bmp, .svg files

---

## 🎯 Success Criteria

A successful test should verify:
- ✅ Authentication is properly enforced
- ✅ File validation works correctly
- ✅ Images are stored with proper naming convention
- ✅ Database records are created correctly
- ✅ Previous images are deactivated
- ✅ Response contains all required fields
- ✅ Proper HTTP status codes are returned
- ✅ Error messages are descriptive and helpful

This comprehensive testing approach ensures the profile photo upload system works reliably in all scenarios!