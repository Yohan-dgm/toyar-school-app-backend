/**
 * EmptyNotifications Component
 * 
 * Empty state component for notification list with different states:
 * - No notifications at all
 * - No unread notifications
 * - No notifications for specific filter
 * - Connection issues
 */

import React from 'react';
import {
  View,
  Text,
  StyleSheet,
  TouchableOpacity
} from 'react-native';

const EmptyNotifications = ({ 
  filter = 'all',
  onRefresh,
  connectionStatus = 'connected'
}) => {
  /**
   * Get empty state content based on filter
   */
  const getEmptyContent = () => {
    if (connectionStatus !== 'connected') {
      return {
        icon: '📡',
        title: 'Connection Issue',
        subtitle: 'Unable to load notifications. Please check your internet connection.',
        showRefresh: true
      };
    }

    switch (filter) {
      case 'unread':
        return {
          icon: '✅',
          title: 'All caught up!',
          subtitle: 'You have no unread notifications.',
          showRefresh: false
        };

      case 'read':
        return {
          icon: '📖',
          title: 'No read notifications',
          subtitle: 'Your read notifications will appear here.',
          showRefresh: true
        };

      case 'urgent':
        return {
          icon: '🚨',
          title: 'No urgent notifications',
          subtitle: 'Your urgent notifications will appear here.',
          showRefresh: true
        };

      case 'high':
        return {
          icon: '⚡',
          title: 'No high priority notifications',
          subtitle: 'Your high priority notifications will appear here.',
          showRefresh: true
        };

      case 'normal':
        return {
          icon: '📄',
          title: 'No normal notifications',
          subtitle: 'Your normal notifications will appear here.',
          showRefresh: true
        };

      case 'all':
      default:
        return {
          icon: '📬',
          title: 'No notifications yet',
          subtitle: 'When you receive notifications, they\'ll appear here.',
          showRefresh: true
        };
    }
  };

  const content = getEmptyContent();

  return (
    <View style={styles.container}>
      <View style={styles.content}>
        {/* Icon */}
        <Text style={styles.icon}>{content.icon}</Text>
        
        {/* Title */}
        <Text style={styles.title}>{content.title}</Text>
        
        {/* Subtitle */}
        <Text style={styles.subtitle}>{content.subtitle}</Text>
        
        {/* Refresh button */}
        {content.showRefresh && (
          <TouchableOpacity
            style={styles.refreshButton}
            onPress={onRefresh}
          >
            <Text style={styles.refreshButtonText}>
              {connectionStatus !== 'connected' ? 'Try Again' : 'Refresh'}
            </Text>
          </TouchableOpacity>
        )}

        {/* Connection status */}
        {connectionStatus !== 'connected' && (
          <View style={styles.statusContainer}>
            <View style={[
              styles.statusIndicator,
              { backgroundColor: getStatusColor(connectionStatus) }
            ]} />
            <Text style={styles.statusText}>
              {getStatusText(connectionStatus)}
            </Text>
          </View>
        )}
      </View>
    </View>
  );
};

/**
 * Get status color based on connection status
 */
const getStatusColor = (status) => {
  switch (status) {
    case 'connected':
      return '#4CAF50';
    case 'connecting':
      return '#FF9800';
    case 'disconnected':
    case 'error':
      return '#FF3B30';
    default:
      return '#8E8E93';
  }
};

/**
 * Get status text based on connection status
 */
const getStatusText = (status) => {
  switch (status) {
    case 'connected':
      return 'Connected';
    case 'connecting':
      return 'Connecting...';
    case 'disconnected':
      return 'Disconnected';
    case 'error':
      return 'Connection Error';
    case 'unavailable':
      return 'Service Unavailable';
    default:
      return 'Unknown Status';
  }
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    paddingHorizontal: 32,
    paddingVertical: 60,
    backgroundColor: '#F8F9FA',
  },
  content: {
    alignItems: 'center',
    maxWidth: 280,
  },
  icon: {
    fontSize: 64,
    marginBottom: 24,
  },
  title: {
    fontSize: 20,
    fontWeight: '600',
    color: '#1A1A1A',
    textAlign: 'center',
    marginBottom: 8,
  },
  subtitle: {
    fontSize: 16,
    color: '#666666',
    textAlign: 'center',
    lineHeight: 22,
    marginBottom: 32,
  },
  refreshButton: {
    paddingHorizontal: 24,
    paddingVertical: 12,
    backgroundColor: '#007AFF',
    borderRadius: 8,
    marginBottom: 16,
  },
  refreshButtonText: {
    color: '#FFFFFF',
    fontSize: 16,
    fontWeight: '500',
  },
  statusContainer: {
    flexDirection: 'row',
    alignItems: 'center',
    paddingHorizontal: 12,
    paddingVertical: 6,
    backgroundColor: '#FFFFFF',
    borderRadius: 16,
    borderWidth: 1,
    borderColor: '#E0E0E0',
  },
  statusIndicator: {
    width: 8,
    height: 8,
    borderRadius: 4,
    marginRight: 8,
  },
  statusText: {
    fontSize: 14,
    color: '#666666',
    fontWeight: '500',
  },
});

export default EmptyNotifications;