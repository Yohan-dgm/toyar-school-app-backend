# Activity Feed Management Module

This module provides comprehensive school posts/activity feed functionality for the Laravel-based multi-tenant school management system.

## Features

-   Create, read, update school posts
-   Support for different post types: announcement, event, news, achievement
-   Media attachments (images, videos, PDFs) with thumbnails
-   Hashtag extraction and management
-   Like/unlike functionality with real-time counts
-   Advanced filtering and search capabilities
-   Pagination support
-   Multi-tenant database support

## Database Tables

-   `activity_feed_posts` - Main posts table
-   `activity_feed_media` - Media attachments
-   `activity_feed_hashtags` - Hashtag associations
-   `activity_feed_likes` - Like tracking

## API Endpoints

All endpoints are prefixed with `/api/activity-feed-management/school-posts/`

### 1. Create School Post

-   **Endpoint**: `POST /create`
-   **Authentication**: Required (AuthGuard middleware)
-   **Request Body**:

```json
{
    "type": "announcement|event|news|achievement",
    "category": "string (optional)",
    "title": "string (required, max 500)",
    "content": "string (required)",
    "school_id": "integer (required)",
    "class_id": "integer (optional)",
    "student_id": "integer (optional)",
    "media": [
        {
            "type": "image|video|pdf",
            "url": "string",
            "thumbnail_url": "string (optional)",
            "filename": "string",
            "size": "integer",
            "mime_type": "string (optional)"
        }
    ]
}
```

### 2. Get School Posts

-   **Endpoint**: `POST /list`
-   **Authentication**: Required (AuthGuard middleware)
-   **Request Body**:

```json
{
    "page": "integer (optional, default: 1)",
    "page_size": "integer (optional, default: 10, max: 100)",
    "search_phrase": "string (optional)",
    "search_filter_list": [
        {
            "type": "post_type|category|date_from|date_to|hashtags",
            "value": "string|array (depending on type)"
        }
    ]
}
```

### 3. Update School Post

-   **Endpoint**: `POST /update`
-   **Authentication**: Required (AuthGuard middleware)
-   **Request Body**:

```json
{
    "id": "integer (required)",
    "type": "string (optional)",
    "category": "string (optional)",
    "title": "string (optional)",
    "content": "string (optional)",
    "media": "array (optional, replaces all existing media)"
}
```

### 4. Toggle Like

-   **Endpoint**: `POST /toggle-like`
-   **Authentication**: Required (AuthGuard middleware)
-   **Request Body**:

```json
{
    "post_id": "integer (required)"
}
```

## Setup Instructions

### 1. Module Registration

The module is already registered in:

-   `bootstrap/providers.php` - Service provider registration
-   `bootstrap/app.php` - Route registration

### 2. Database Setup

Run the database setup script to create tables and insert dummy data:

```php
// In tinker or a custom command
include base_path('modules/ActivityFeedManagement/Database/setup_tables.php');
```

Or manually execute the SQL files in this order:

1. `Database/Sql/activity_feed_posts.sql`
2. `Database/Sql/activity_feed_media.sql`
3. `Database/Sql/activity_feed_hashtags.sql`
4. `Database/Sql/activity_feed_likes.sql`

### 3. Testing with Postman

1. Import the `postman_collection.json` file into Postman
2. Set the `base_url` variable to your application URL
3. Ensure you have proper authentication headers/cookies set up
4. Test each endpoint with the provided sample requests

## File Structure

```
modules/ActivityFeedManagement/
├── Database/
│   ├── Sql/
│   │   ├── activity_feed_posts.sql
│   │   ├── activity_feed_media.sql
│   │   ├── activity_feed_hashtags.sql
│   │   └── activity_feed_likes.sql
│   └── setup_tables.php
├── Intents/
│   └── SchoolPost/
│       ├── CreateSchoolPost/
│       ├── GetSchoolPosts/
│       ├── UpdateSchoolPost/
│       └── ToggleLike/
├── Models/
│   ├── ActivityFeedPost.php
│   ├── ActivityFeedMedia.php
│   ├── ActivityFeedHashtag.php
│   └── ActivityFeedLike.php
├── Providers/
│   └── ActivityFeedManagementServiceProvider.php
├── config.php
├── routes.php
├── postman_collection.json
└── README.md
```

## Response Format

All API responses follow the standard format:

```json
{
    "status": "successful|error",
    "message": "string",
    "data": "object|array|null",
    "metadata": "object|null"
}
```

## Dependencies

-   Laravel Framework
-   Spatie Laravel Data (for DTOs)
-   Lorisleiva Actions (for action classes)
-   PostgreSQL database
-   AuthGuard middleware (custom authentication)

## Notes

-   All posts are school-wide by default (class_id and student_id are null)
-   Hashtags are automatically extracted from post content using regex
-   Media files support sorting via sort_order field
-   Like counts are maintained in real-time
-   All operations are wrapped in database transactions where appropriate
