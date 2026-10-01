# Modern Notification System Database Schema

## Core Tables

### 2. notification_types

```sql
id (UUID, Primary Key)
name (VARCHAR, Unique) -- 'message', 'friend_request', 'group_invite', 'system_alert', 'promotional'
display_name (VARCHAR)
description (TEXT)
icon (VARCHAR)
color (VARCHAR)
sound (VARCHAR)
default_priority (ENUM: low, normal, high, critical)
is_active (BOOLEAN, Default: true)
requires_action (BOOLEAN, Default: false)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 3. notifications

```sql
id (UUID, Primary Key)
type_id (UUID, Foreign Key)
sender_id (UUID, Foreign Key, Nullable) -- NULL for system notifications
title (VARCHAR, NOT NULL)
body (TEXT, NOT NULL)
data (JSON) -- Additional payload data
image_url (VARCHAR)
action_url (VARCHAR)
deep_link (VARCHAR)
priority (ENUM: low, normal, high, critical)
category (VARCHAR) -- For iOS notification categories
badge_count (INTEGER, Default: 0)
sound (VARCHAR)
vibration_pattern (VARCHAR)
ttl (INTEGER) -- Time to live in seconds
expires_at (TIMESTAMP)
scheduled_at (TIMESTAMP) -- For scheduled notifications
status (ENUM: draft, scheduled, sent, delivered, failed, cancelled)
is_silent (BOOLEAN, Default: false)
is_persistent (BOOLEAN, Default: false)
group_key (VARCHAR) -- For notification grouping
collapse_key (VARCHAR) -- For collapsing similar notifications
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 4. user_notifications

```sql
id (UUID, Primary Key)
notification_id (UUID, Foreign Key)
user_id (UUID, Foreign Key)
status (ENUM: pending, delivered, read, dismissed, failed)
delivered_at (TIMESTAMP)
read_at (TIMESTAMP)
dismissed_at (TIMESTAMP)
clicked_at (TIMESTAMP)
is_hidden (BOOLEAN, Default: false)
read_receipt_sent (BOOLEAN, Default: false)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 5. groups

```sql
id (UUID, Primary Key)
name (VARCHAR, NOT NULL)
description (TEXT)
avatar_url (VARCHAR)
type (ENUM: public, private, broadcast, channel)
admin_id (UUID, Foreign Key)
max_members (INTEGER)
is_active (BOOLEAN, Default: true)
settings (JSON) -- Group-specific notification settings
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 6. group_members

```sql
id (UUID, Primary Key)
group_id (UUID, Foreign Key)
user_id (UUID, Foreign Key)
role (ENUM: admin, moderator, member)
status (ENUM: active, muted, banned, left)
joined_at (TIMESTAMP)
left_at (TIMESTAMP)
muted_until (TIMESTAMP)
permissions (JSON)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 7. notification_targets

```sql
id (UUID, Primary Key)
notification_id (UUID, Foreign Key)
target_type (ENUM: user, group, all_users, user_segment)
target_id (UUID, Nullable) -- user_id or group_id based on target_type
created_at (TIMESTAMP)
```

### 8. user_devices

```sql
id (UUID, Primary Key)
user_id (UUID, Foreign Key)
device_token (VARCHAR, Unique, Index) -- FCM/APNS token
device_id (VARCHAR, Index)
platform (ENUM: ios, android, web)
app_version (VARCHAR)
os_version (VARCHAR)
device_model (VARCHAR)
is_active (BOOLEAN, Default: true)
timezone (VARCHAR)
last_seen_at (TIMESTAMP)
registration_date (TIMESTAMP)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 9. push_notification_logs

```sql
id (UUID, Primary Key)
notification_id (UUID, Foreign Key)
device_id (UUID, Foreign Key)
provider (ENUM: fcm, apns, web_push)
provider_message_id (VARCHAR)
status (ENUM: queued, sent, delivered, failed, clicked)
response_data (JSON)
error_message (TEXT)
retry_count (INTEGER, Default: 0)
sent_at (TIMESTAMP)
delivered_at (TIMESTAMP)
clicked_at (TIMESTAMP)
created_at (TIMESTAMP)
```

### 10. user_notification_settings

```sql
id (UUID, Primary Key)
user_id (UUID, Foreign Key)
notification_type_id (UUID, Foreign Key)
is_enabled (BOOLEAN, Default: true)
push_enabled (BOOLEAN, Default: true)
email_enabled (BOOLEAN, Default: false)
sms_enabled (BOOLEAN, Default: false)
in_app_enabled (BOOLEAN, Default: true)
sound_enabled (BOOLEAN, Default: true)
vibration_enabled (BOOLEAN, Default: true)
priority_override (ENUM: low, normal, high, critical, Nullable)
quiet_hours_start (TIME)
quiet_hours_end (TIME)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 11. messages

```sql
id (UUID, Primary Key)
conversation_id (UUID, Foreign Key)
sender_id (UUID, Foreign Key)
reply_to_id (UUID, Foreign Key, Nullable)
content (TEXT)
message_type (ENUM: text, image, video, audio, file, location, contact, system)
media_url (VARCHAR)
media_thumbnail (VARCHAR)
media_duration (INTEGER) -- For audio/video
file_size (BIGINT)
mime_type (VARCHAR)
metadata (JSON)
is_edited (BOOLEAN, Default: false)
edited_at (TIMESTAMP)
is_deleted (BOOLEAN, Default: false)
deleted_at (TIMESTAMP)
status (ENUM: sending, sent, delivered, failed)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 12. conversations

```sql
id (UUID, Primary Key)
type (ENUM: direct, group, channel, broadcast)
name (VARCHAR)
description (TEXT)
avatar_url (VARCHAR)
last_message_id (UUID, Foreign Key, Nullable)
last_activity_at (TIMESTAMP)
is_archived (BOOLEAN, Default: false)
is_muted (BOOLEAN, Default: false)
settings (JSON)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 13. conversation_participants

```sql
id (UUID, Primary Key)
conversation_id (UUID, Foreign Key)
user_id (UUID, Foreign Key)
role (ENUM: admin, moderator, member)
status (ENUM: active, left, removed, banned)
joined_at (TIMESTAMP)
left_at (TIMESTAMP)
last_read_message_id (UUID)
last_read_at (TIMESTAMP)
unread_count (INTEGER, Default: 0)
is_muted (BOOLEAN, Default: false)
muted_until (TIMESTAMP)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 14. message_read_receipts

```sql
id (UUID, Primary Key)
message_id (UUID, Foreign Key)
user_id (UUID, Foreign Key)
read_at (TIMESTAMP)
created_at (TIMESTAMP)
```

### 15. notification_templates

```sql
id (UUID, Primary Key)
name (VARCHAR, Unique)
type_id (UUID, Foreign Key)
title_template (VARCHAR)
body_template (TEXT)
variables (JSON) -- Template variables definition
language_code (VARCHAR, Default: 'en')
is_active (BOOLEAN, Default: true)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 16. user_segments

```sql
id (UUID, Primary Key)
name (VARCHAR, NOT NULL)
description (TEXT)
criteria (JSON) -- Segmentation criteria
user_count (INTEGER, Default: 0)
is_active (BOOLEAN, Default: true)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 17. notification_campaigns

```sql
id (UUID, Primary Key)
name (VARCHAR, NOT NULL)
description (TEXT)
template_id (UUID, Foreign Key)
target_segment_id (UUID, Foreign Key, Nullable)
scheduled_at (TIMESTAMP)
status (ENUM: draft, scheduled, running, completed, cancelled, failed)
total_recipients (INTEGER, Default: 0)
delivered_count (INTEGER, Default: 0)
read_count (INTEGER, Default: 0)
click_count (INTEGER, Default: 0)
settings (JSON)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 18. notification_analytics

```sql
id (UUID, Primary Key)
notification_id (UUID, Foreign Key)
user_id (UUID, Foreign Key)
event_type (ENUM: sent, delivered, read, clicked, dismissed)
device_platform (ENUM: ios, android, web)
timestamp (TIMESTAMP)
metadata (JSON)
created_at (TIMESTAMP)
```

### 19. user_presence

```sql
id (UUID, Primary Key)
user_id (UUID, Foreign Key, Unique)
status (ENUM: online, away, busy, invisible, offline)
last_seen_at (TIMESTAMP)
current_activity (VARCHAR)
device_info (JSON)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

### 20. notification_queues

```sql
id (UUID, Primary Key)
notification_id (UUID, Foreign Key)
user_id (UUID, Foreign Key)
priority (INTEGER, Default: 5) -- 1 = highest, 10 = lowest
scheduled_at (TIMESTAMP)
retry_count (INTEGER, Default: 0)
max_retries (INTEGER, Default: 3)
status (ENUM: pending, processing, completed, failed, cancelled)
error_message (TEXT)
created_at (TIMESTAMP)
updated_at (TIMESTAMP)
```

## Essential Indexes

### Performance Indexes

```sql
-- User notifications queries
CREATE INDEX idx_user_notifications_user_status ON user_notifications(user_id, status);
CREATE INDEX idx_user_notifications_notification_id ON user_notifications(notification_id);

-- Message read receipts
CREATE INDEX idx_message_read_receipts_message_user ON message_read_receipts(message_id, user_id);
CREATE INDEX idx_message_read_receipts_user_read_at ON message_read_receipts(user_id, read_at);

-- Notifications
CREATE INDEX idx_notifications_created_at ON notifications(created_at DESC);
CREATE INDEX idx_notifications_status_priority ON notifications(status, priority);
CREATE INDEX idx_notifications_sender_created ON notifications(sender_id, created_at);

-- Push notification logs
CREATE INDEX idx_push_logs_notification_device ON push_notification_logs(notification_id, device_id);
CREATE INDEX idx_push_logs_status_created ON push_notification_logs(status, created_at);

-- User devices
CREATE INDEX idx_user_devices_user_active ON user_devices(user_id, is_active);
CREATE INDEX idx_user_devices_token ON user_devices(device_token);

-- Conversation participants
CREATE INDEX idx_conv_participants_user ON conversation_participants(user_id, status);
CREATE INDEX idx_conv_participants_conv_user ON conversation_participants(conversation_id, user_id);

-- Messages
CREATE INDEX idx_messages_conversation_created ON messages(conversation_id, created_at DESC);
CREATE INDEX idx_messages_sender ON messages(sender_id);

-- Notification queue
CREATE INDEX idx_notification_queues_status_priority ON notification_queues(status, priority, scheduled_at);
```

## Relations Documentation

### Primary Relationships

**users → user_notifications**: One user can have many notifications

-   `users.id` connects to `user_notifications.user_id`

**notifications → user_notifications**: One notification can be sent to many users

-   `notifications.id` connects to `user_notifications.notification_id`

**notification_types → notifications**: Each notification belongs to a type

-   `notification_types.id` connects to `notifications.type_id`

**users → notifications**: A user can send notifications (nullable for system notifications)

-   `users.id` connects to `notifications.sender_id`

**groups → group_members**: A group has many members

-   `groups.id` connects to `group_members.group_id`

**users → group_members**: A user can be member of many groups

-   `users.id` connects to `group_members.user_id`

**notifications → notification_targets**: A notification can have multiple targets

-   `notifications.id` connects to `notification_targets.notification_id`

**users → user_devices**: A user can have multiple devices

-   `users.id` connects to `user_devices.user_id`

**notifications → push_notification_logs**: Track push delivery per notification

-   `notifications.id` connects to `push_notification_logs.notification_id`

**user_devices → push_notification_logs**: Track which device received push

-   `user_devices.id` connects to `push_notification_logs.device_id`

**users → user_notification_settings**: User-specific notification preferences

-   `users.id` connects to `user_notification_settings.user_id`

**notification_types → user_notification_settings**: Settings per notification type

-   `notification_types.id` connects to `user_notification_settings.notification_type_id`

### Messaging Integration Relationships

**conversations → messages**: A conversation contains many messages

-   `conversations.id` connects to `messages.conversation_id`

**users → messages**: A user sends messages

-   `users.id` connects to `messages.sender_id`

**messages → message_read_receipts**: Track who read each message

-   `messages.id` connects to `message_read_receipts.message_id`

**users → message_read_receipts**: Track what messages user has read

-   `users.id` connects to `message_read_receipts.user_id`

**conversations → conversation_participants**: Track conversation members

-   `conversations.id` connects to `conversation_participants.conversation_id`

**users → conversation_participants**: User participation in conversations

-   `users.id` connects to `conversation_participants.user_id`

### Advanced Relationships

**notification_templates → notifications**: Use templates for notifications

-   `notification_templates.id` connects to `notifications.template_id` (if using templates)

**user_segments → notification_campaigns**: Target specific user segments

-   `user_segments.id` connects to `notification_campaigns.target_segment_id`

**notification_templates → notification_campaigns**: Campaign uses template

-   `notification_templates.id` connects to `notification_campaigns.template_id`

**notifications → notification_analytics**: Track notification performance

-   `notifications.id` connects to `notification_analytics.notification_id`

**users → user_presence**: Track user online status

-   `users.id` connects to `user_presence.user_id`

**notifications → notification_queues**: Queue notifications for processing

-   `notifications.id` connects to `notification_queues.notification_id`

## Key Features Supported

✅ **Individual User Notifications**: Direct user targeting via `user_notifications`
✅ **Group Notifications**: Group targeting via `groups` and `group_members`
✅ **Broadcast to All Users**: Using `target_type = 'all_users'` in `notification_targets`
✅ **Priority Levels**: Low, normal, high, critical priority support
✅ **Push Notification Integration**: Complete device and push log tracking
✅ **Message Read Receipts**: Track who has read messages via `message_read_receipts`
✅ **Unread Tracking**: Unread counts in `conversation_participants`
✅ **Active User Reporting**: Real-time presence via `user_presence`
✅ **Notification Analytics**: Comprehensive tracking and reporting
✅ **Scalable Queue System**: Handle high-volume notifications
✅ **Template System**: Reusable notification templates
✅ **User Preferences**: Granular notification settings per user/type
✅ **Campaign Management**: Bulk notification campaigns
✅ **Multi-device Support**: Track and target multiple user devices
