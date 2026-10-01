# Storage API Documentation

## Overview

This document describes the secure file serving API for the Laravel school management system. The API provides authenticated access to ALL files stored in the `/storage/app/` directory, including images, videos, PDFs, documents, and any other file types.

## Authentication

All storage endpoints require Bearer token authentication using the same AuthGuard middleware used throughout the application.

**Headers Required:**
```
Authorization: Bearer YOUR_TOKEN_HERE
Content-Type: application/json (for info endpoints)
```

## Storage Structure

The API provides access to the entire `/storage/app/` directory structure. Example structure:

```
/storage/app/
├── nexis-college/
│   └── yakkala/
│       └── activity-feed/
│           └── media/
│               ├── image/
│               │   ├── sample.jpg
│               │   ├── sports-day-poster.jpg
│               │   └── welcome-banner.jpg
│               ├── video/
│               │   └── video.mp4
│               ├── pdf/
│               │   └── sample.pdf
│               └── thumbs/
│                   └── sample.webp
├── documents/
│   ├── reports/
│   └── templates/
├── uploads/
│   ├── user-profiles/
│   └── attachments/
└── backups/
    └── database/
```

## API Endpoints

### 1. List Directory Contents

**Endpoint:** `GET /api/storage/list/{directory?}`

**Description:** Lists all files and subdirectories in the specified directory.

**Examples:**
- `GET /api/storage/list` - List root storage/app directory
- `GET /api/storage/list/nexis-college` - List nexis-college directory
- `GET /api/storage/list/nexis-college/yakkala/activity-feed/media` - List media directory

**Response:**
```json
{
    "status": "successful",
    "message": "Directory listing retrieved",
    "data": {
        "current_directory": "nexis-college",
        "items": [
            {
                "name": "document.pdf",
                "path": "nexis-college/document.pdf",
                "type": "file",
                "size": 245760,
                "size_formatted": "240.00 KB",
                "mime_type": "application/pdf",
                "last_modified": "2024-01-15 10:30:45"
            },
            {
                "name": "yakkala",
                "path": "nexis-college/yakkala",
                "type": "directory",
                "size": null,
                "size_formatted": null,
                "mime_type": null,
                "last_modified": null
            }
        ],
        "total_files": 1,
        "total_directories": 1
    }
}
```

### 2. Serve File by Path

**Endpoint:** `GET /api/storage/file/{path}`

**Description:** Serves files directly by their relative path from the storage/app directory.

**Examples:**
- `GET /api/storage/file/nexis-college/yakkala/activity-feed/media/image/sample.jpg`
- `GET /api/storage/file/nexis-college/yakkala/activity-feed/media/video/video.mp4`
- `GET /api/storage/file/documents/reports/monthly-report.pdf`
- `GET /api/storage/file/uploads/user-profiles/avatar.png`

**Response:** 
- **Success (200):** Returns the file with appropriate headers
- **Unauthorized (401):** Authentication required
- **Not Found (404):** File not found
- **Server Error (500):** Internal server error

**Response Headers:**
```
Content-Type: [appropriate MIME type]
Content-Length: [file size]
Content-Disposition: inline; filename="[filename]"
Cache-Control: private, max-age=3600
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
```

### 3. Serve File by Directory

**Endpoint:** `GET /api/storage/dir/{directory}/{filename}`

**Description:** Alternative endpoint for serving files from specific directories.

**Examples:**
- `GET /api/storage/dir/nexis-college/document.pdf`
- `GET /api/storage/dir/uploads/profile-photo.jpg`

### 4. Get File Information

**Endpoint:** `GET /api/storage/info/{path}`

**Description:** Returns metadata about a file without downloading it.

**Examples:**
- `GET /api/storage/info/nexis-college/yakkala/activity-feed/media/image/sample.jpg`
- `GET /api/storage/info/documents/reports/monthly-report.pdf`

**Response:**
```json
{
    "status": "successful",
    "message": "File info retrieved",
    "data": {
        "filename": "sample.jpg",
        "path": "nexis-college/yakkala/activity-feed/media/image/sample.jpg",
        "mime_type": "image/jpeg",
        "size": 245760,
        "size_formatted": "240.00 KB",
        "last_modified": "2024-01-15 10:30:45",
        "type": "image"
    }
}
```

## Module-Specific Endpoints

The same endpoints are also available under the ActivityFeedManagement module:

- `GET /api/activity-feed-management/storage/list/{directory?}`
- `GET /api/activity-feed-management/storage/file/{path}`
- `GET /api/activity-feed-management/storage/info/{path}`

## Frontend Integration

### React Native Example

```javascript
// Function to get storage file URL with authentication
const getStorageFileUrl = (filePath) => {
    return `http://192.168.1.5:9999/api/storage/file/${filePath}`;
};

// Function to fetch file with authentication
const fetchStorageFile = async (filePath, token) => {
    try {
        const response = await fetch(getStorageFileUrl(filePath), {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
            },
        });
        
        if (response.ok) {
            return response.blob(); // For images/videos
        } else {
            throw new Error('Failed to fetch file');
        }
    } catch (error) {
        console.error('File fetch error:', error);
        throw error;
    }
};

// Function to list directory contents
const listDirectory = async (directory, token) => {
    try {
        const url = directory 
            ? `http://192.168.1.5:9999/api/storage/list/${directory}`
            : `http://192.168.1.5:9999/api/storage/list`;
            
        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json',
            },
        });
        
        if (response.ok) {
            return response.json();
        } else {
            throw new Error('Failed to list directory');
        }
    } catch (error) {
        console.error('Directory listing error:', error);
        throw error;
    }
};

// Usage in React Native component
const FileViewer = ({ filePath, token }) => {
    const [fileUri, setFileUri] = useState(null);
    
    useEffect(() => {
        const loadFile = async () => {
            try {
                const blob = await fetchStorageFile(filePath, token);
                const uri = URL.createObjectURL(blob);
                setFileUri(uri);
            } catch (error) {
                console.error('Error loading file:', error);
            }
        };
        
        loadFile();
    }, [filePath, token]);
    
    return (
        <Image 
            source={{ uri: fileUri }}
            style={{ width: 200, height: 200 }}
        />
    );
};
```

## Security Features

1. **Authentication Required:** All endpoints require valid Bearer token
2. **Path Sanitization:** Prevents directory traversal attacks (../, ..\\)
3. **File Existence Check:** Validates file exists before serving
4. **MIME Type Detection:** Proper content type headers
5. **Security Headers:** Includes security headers to prevent XSS
6. **Error Logging:** Logs errors for monitoring
7. **Cache Control:** Private caching to prevent unauthorized access

## Supported File Types

- **Images:** JPG, JPEG, PNG, GIF, WebP, SVG, BMP, TIFF
- **Videos:** MP4, AVI, MOV, WebM, MKV, FLV
- **Documents:** PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX
- **Text Files:** TXT, CSV, JSON, XML, HTML
- **Archives:** ZIP, RAR, 7Z
- **Any other file type stored in storage/app**

## Testing

### Test with cURL

```bash
# List root directory
curl -H "Authorization: Bearer YOUR_TOKEN" \
     -H "Content-Type: application/json" \
     http://192.168.1.5:9999/api/storage/list

# List specific directory
curl -H "Authorization: Bearer YOUR_TOKEN" \
     -H "Content-Type: application/json" \
     http://192.168.1.5:9999/api/storage/list/nexis-college

# Download image file
curl -H "Authorization: Bearer YOUR_TOKEN" \
     http://192.168.1.5:9999/api/storage/file/nexis-college/yakkala/activity-feed/media/image/sample.jpg \
     --output downloaded-image.jpg

# Get file info
curl -H "Authorization: Bearer YOUR_TOKEN" \
     -H "Content-Type: application/json" \
     http://192.168.1.5:9999/api/storage/info/nexis-college/yakkala/activity-feed/media/image/sample.jpg

# Download PDF
curl -H "Authorization: Bearer YOUR_TOKEN" \
     http://192.168.1.5:9999/api/storage/file/nexis-college/yakkala/activity-feed/media/pdf/sample.pdf \
     --output downloaded-document.pdf
```

### Test with Postman

1. **Set Authorization:** Bearer Token with your authentication token
2. **Set Method:** GET
3. **Set URL:** `http://192.168.1.5:9999/api/storage/list` (to list files)
4. **Send Request:** Should return directory listing
5. **Test file serving:** `http://192.168.1.5:9999/api/storage/file/nexis-college/yakkala/activity-feed/media/image/sample.jpg`

## Error Handling

### Common Error Responses

**Authentication Error (401):**
```json
{
    "status": "error",
    "message": "Unauthorized access"
}
```

**File Not Found (404):**
```json
{
    "status": "error",
    "message": "File not found"
}
```

**Server Error (500):**
```json
{
    "status": "error",
    "message": "Error serving file"
}
```

## Performance Considerations

1. **Caching:** Files are cached for 1 hour (3600 seconds)
2. **Direct Serving:** Files are served directly from storage without processing
3. **Streaming:** Large files are streamed efficiently
4. **Memory Usage:** Minimal memory footprint for file serving
5. **Path Sanitization:** Lightweight security checks

## Next Steps

1. Test the endpoints with your authentication token
2. Explore your storage directory structure using the list endpoint
3. Integrate with your React Native frontend
4. Update your activity feed posts to use the new storage URLs
5. Consider implementing file upload endpoints if needed
6. Set up proper file organization in your storage directories
