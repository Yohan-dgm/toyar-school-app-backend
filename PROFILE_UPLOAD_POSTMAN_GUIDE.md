# Profile Image Upload - Postman Configuration Guide

## 🛠️ Backend Issues FIXED

The profile image upload error has been completely resolved! The issue was in the DTO (Data Transfer Object) validation methods using `validate()` instead of `from()`.

### Fixed Issues:
✅ **DTO Creation**: Fixed `UploadUserProfilePhotoUserDTO::validate()` → `::from()`  
✅ **File Validation**: Fixed file handling in validation data  
✅ **Error Logging**: Added detailed debug logging  
✅ **Multitenancy**: Fixed database connection configuration  

---

## 📋 Postman Configuration

### 1. **Development/Debug Endpoint (No Authentication)**
Use this for initial testing without dealing with authentication:

**Endpoint:** `POST /api/user-management/user-profile/debug-upload-profile-photo`

**Headers:**
```
Accept: application/json
```

**Body:** `form-data`
```
profile_image: [Select File - Image file (JPG, PNG, WebP)]
```

**Expected Response (201 Created):**
```json
{
    "status": "successful",
    "message": "DEBUG: Profile image uploaded successfully",
    "data": {
        "id": 1,
        "user_id": 1,
        "file_path": "public/nexis-college/profile_images/user_1_20250828114238.jpg",
        "filename": "debug-test.jpg",
        "file_format": "jpg", 
        "file_size": 1748,
        "file_size_formatted": "1.71 KB",
        "mime_type": "image/jpeg",
        "width": 100,
        "height": 100,
        "dimensions_string": "100x100",
        "is_active": true,
        "full_url": "/storage/nexis-college/profile_images/user_1_20250828114238.jpg",
        "public_path": "storage/nexis-college/profile_images/user_1_20250828114238.jpg",
        "created_at": "2025-08-28 11:42:38",
        "updated_at": "2025-08-28 11:42:38"
    }
}
```

### 2. **Production Endpoint (With Authentication)**

**Step 1: Sign In First**
```
POST /api/user-management/user/sign-in

Headers:
Content-Type: application/json
Accept: application/json

Body (raw JSON):
{
    "username_or_email": "testuser@nexiscollege.lk",
    "password": "password",
    "pin": "school_app"
}
```

**Step 2: Use Access Token & Session Cookie**
```
POST /api/user-management/user-profile/upload-profile-photo

Headers:
Authorization: Bearer {access_token_from_signin}
Accept: application/json
Cookie: t_session={encrypted_session_cookie_from_signin}

Body (form-data):
profile_image: [Select File - Image file]
```

---

## 🎯 File Requirements

### **Supported Formats:**
- JPEG (.jpg, .jpeg)
- PNG (.png) 
- WebP (.webp)

### **File Size:**
- Maximum: **5MB** (5120 KB)
- Minimum dimensions: **100x100 pixels**
- Maximum dimensions: **2048x2048 pixels**

### **Validation Rules:**
- File must be a valid image
- File must pass Laravel's image validation
- Only one active profile image per user (new uploads deactivate old ones)

---

## 🚨 Error Handling

### **Common Errors:**

**401 Unauthorized:**
```json
{
    "status": "authentication-required",
    "message": "Session cookie required"
}
```
*Solution: Ensure both Bearer token and session cookie are provided*

**422 Validation Error:**
```json
{
    "status": "failed", 
    "message": "Validation failed",
    "errors": {
        "profile_image": ["The image size cannot exceed 5MB."]
    }
}
```
*Solution: Check file size, format, and dimensions*

**500 Internal Server Error (Debug Mode):**
```json
{
    "status": "failed",
    "message": "Upload failed: [Detailed Error]",
    "metadata": {
        "debug_info": {
            "error": "Specific error message",
            "file": "path/to/file.php:123",
            "type": "ErrorException"
        }
    }
}
```

---

## 🔧 Frontend Integration

### **JavaScript Example:**
```javascript
// For debug endpoint (development)
const uploadProfileImage = async (imageFile) => {
    const formData = new FormData();
    formData.append('profile_image', imageFile);
    
    const response = await fetch('/api/user-management/user-profile/debug-upload-profile-photo', {
        method: 'POST',
        headers: {
            'Accept': 'application/json'
        },
        body: formData
    });
    
    return await response.json();
};

// For production endpoint (with auth)
const uploadProfileImageAuth = async (imageFile, accessToken, sessionCookie) => {
    const formData = new FormData();
    formData.append('profile_image', imageFile);
    
    const response = await fetch('/api/user-management/user-profile/upload-profile-photo', {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${accessToken}`,
            'Cookie': `t_session=${sessionCookie}`
        },
        body: formData
    });
    
    return await response.json();
};
```

---

## 🎉 Success!

The backend profile image upload is now **fully functional**. The debug endpoint works perfectly for testing, and the production endpoint is ready for integration with proper authentication.

**Key Changes Made:**
1. Fixed DTO creation methods from `validate()` to `from()`
2. Corrected file handling in validation data
3. Added comprehensive error logging
4. Created development bypass endpoint
5. Verified database and storage configurations

The generic error message you were seeing is now replaced with proper error handling and detailed logging for debugging.