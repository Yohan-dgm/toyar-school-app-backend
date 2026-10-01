/**
 * NotificationItem Component
 * 
 * Individual notification item component with:
 * - Priority-based styling
 * - Read/unread states
 * - Time formatting
 * - Action buttons
 * - Tap handling
 */

import React from 'react';
import {
  View,
  Text,
  TouchableOpacity,
  StyleSheet,
  Image
} from 'react-native';

const NotificationItem = ({ 
  notification, 
  onPress,
  showActions = false,
  onMarkAsRead,
  onDelete 
}) => {
  /**
   * Get priority color
   */
  const getPriorityColor = (priority) => {
    switch (priority) {
      case 'urgent':
        return '#FF3B30';
      case 'high':
        return '#FF9500';
      case 'normal':
      default:
        return '#007AFF';
    }
  };

  /**
   * Get priority background color
   */
  const getPriorityBackground = (priority, isRead) => {
    const alpha = isRead ? '08' : '15';
    switch (priority) {
      case 'urgent':
        return `#FF3B30${alpha}`;
      case 'high':
        return `#FF9500${alpha}`;
      case 'normal':
      default:
        return `#007AFF${alpha}`;
    }
  };

  /**
   * Format time ago
   */
  const formatTimeAgo = (timestamp) => {
    if (!timestamp) return '';
    
    const now = new Date();
    const notificationTime = new Date(timestamp);
    const diffMs = now - notificationTime;
    const diffMins = Math.floor(diffMs / 60000);
    const diffHours = Math.floor(diffMs / 3600000);
    const diffDays = Math.floor(diffMs / 86400000);

    if (diffMins < 1) return 'Just now';
    if (diffMins < 60) return `${diffMins}m ago`;
    if (diffHours < 24) return `${diffHours}h ago`;
    if (diffDays < 7) return `${diffDays}d ago`;
    
    return notificationTime.toLocaleDateString();
  };

  /**
   * Truncate text
   */
  const truncateText = (text, maxLength = 100) => {
    if (!text || text.length <= maxLength) return text;
    return text.substring(0, maxLength) + '...';
  };

  const priorityColor = getPriorityColor(notification.priority);
  const backgroundColor = getPriorityBackground(notification.priority, notification.isRead);

  return (
    <TouchableOpacity
      style={[
        styles.container,
        { backgroundColor },
        !notification.isRead && styles.unreadContainer
      ]}
      onPress={() => onPress?.(notification)}
      activeOpacity={0.7}
    >
      {/* Priority indicator */}
      <View 
        style={[
          styles.priorityIndicator,
          { backgroundColor: priorityColor }
        ]} 
      />

      {/* Content */}
      <View style={styles.content}>
        {/* Header */}
        <View style={styles.header}>
          <View style={styles.headerLeft}>
            {/* Notification type/category */}
            {notification.typeName && (
              <Text style={[styles.category, { color: priorityColor }]}>
                {notification.typeName}
              </Text>
            )}
            
            {/* Priority label for urgent/high priority */}
            {(notification.priority === 'urgent' || notification.priority === 'high') && (
              <View style={[styles.priorityBadge, { backgroundColor: priorityColor }]}>
                <Text style={styles.priorityBadgeText}>
                  {notification.priorityLabel || notification.priority.toUpperCase()}
                </Text>
              </View>
            )}
          </View>

          <View style={styles.headerRight}>
            {/* Time */}
            <Text style={styles.time}>
              {formatTimeAgo(notification.createdAt)}
            </Text>

            {/* Unread indicator */}
            {!notification.isRead && (
              <View style={styles.unreadDot} />
            )}
          </View>
        </View>

        {/* Title */}
        <Text 
          style={[
            styles.title,
            !notification.isRead && styles.unreadTitle
          ]}
          numberOfLines={2}
        >
          {notification.title}
        </Text>

        {/* Message */}
        <Text 
          style={[
            styles.message,
            !notification.isRead && styles.unreadMessage
          ]}
          numberOfLines={3}
        >
          {truncateText(notification.message, 120)}
        </Text>

        {/* Image (if exists) */}
        {notification.imageUrl && (
          <Image
            source={{ uri: notification.imageUrl }}
            style={styles.image}
            resizeMode="cover"
          />
        )}

        {/* Action button (if exists) */}
        {notification.actionText && (
          <TouchableOpacity
            style={[styles.actionButton, { borderColor: priorityColor }]}
            onPress={(e) => {
              e.stopPropagation();
              onPress?.(notification);
            }}
          >
            <Text style={[styles.actionButtonText, { color: priorityColor }]}>
              {notification.actionText}
            </Text>
          </TouchableOpacity>
        )}

        {/* Actions (if enabled) */}
        {showActions && (
          <View style={styles.actions}>
            {!notification.isRead && (
              <TouchableOpacity
                style={styles.actionItem}
                onPress={(e) => {
                  e.stopPropagation();
                  onMarkAsRead?.(notification);
                }}
              >
                <Text style={styles.actionItemText}>Mark as Read</Text>
              </TouchableOpacity>
            )}
            
            <TouchableOpacity
              style={styles.actionItem}
              onPress={(e) => {
                e.stopPropagation();
                onDelete?.(notification);
              }}
            >
              <Text style={[styles.actionItemText, styles.deleteAction]}>Delete</Text>
            </TouchableOpacity>
          </View>
        )}
      </View>
    </TouchableOpacity>
  );
};

const styles = StyleSheet.create({
  container: {
    flexDirection: 'row',
    backgroundColor: '#FFFFFF',
    marginVertical: 1,
    paddingRight: 16,
  },
  unreadContainer: {
    shadowColor: '#000000',
    shadowOffset: { width: 0, height: 1 },
    shadowOpacity: 0.05,
    shadowRadius: 2,
    elevation: 2,
  },
  priorityIndicator: {
    width: 4,
    backgroundColor: '#007AFF',
  },
  content: {
    flex: 1,
    paddingHorizontal: 16,
    paddingVertical: 12,
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'flex-start',
    marginBottom: 8,
  },
  headerLeft: {
    flexDirection: 'row',
    alignItems: 'center',
    flex: 1,
  },
  headerRight: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  category: {
    fontSize: 12,
    fontWeight: '500',
    color: '#007AFF',
    textTransform: 'uppercase',
    letterSpacing: 0.5,
    marginRight: 8,
  },
  priorityBadge: {
    paddingHorizontal: 6,
    paddingVertical: 2,
    borderRadius: 10,
    backgroundColor: '#FF3B30',
  },
  priorityBadgeText: {
    fontSize: 10,
    fontWeight: '600',
    color: '#FFFFFF',
    textTransform: 'uppercase',
  },
  time: {
    fontSize: 12,
    color: '#8E8E93',
    marginRight: 8,
  },
  unreadDot: {
    width: 8,
    height: 8,
    borderRadius: 4,
    backgroundColor: '#007AFF',
  },
  title: {
    fontSize: 16,
    fontWeight: '500',
    color: '#1A1A1A',
    marginBottom: 4,
    lineHeight: 20,
  },
  unreadTitle: {
    fontWeight: '600',
    color: '#000000',
  },
  message: {
    fontSize: 14,
    color: '#666666',
    lineHeight: 18,
    marginBottom: 8,
  },
  unreadMessage: {
    color: '#333333',
  },
  image: {
    width: '100%',
    height: 120,
    borderRadius: 8,
    marginBottom: 8,
  },
  actionButton: {
    alignSelf: 'flex-start',
    paddingHorizontal: 12,
    paddingVertical: 6,
    borderWidth: 1,
    borderColor: '#007AFF',
    borderRadius: 6,
    marginTop: 4,
  },
  actionButtonText: {
    fontSize: 14,
    fontWeight: '500',
    color: '#007AFF',
  },
  actions: {
    flexDirection: 'row',
    justifyContent: 'flex-end',
    marginTop: 8,
    paddingTop: 8,
    borderTopWidth: 1,
    borderTopColor: '#E0E0E0',
  },
  actionItem: {
    marginLeft: 16,
  },
  actionItemText: {
    fontSize: 14,
    color: '#007AFF',
    fontWeight: '500',
  },
  deleteAction: {
    color: '#FF3B30',
  },
});

export default NotificationItem;