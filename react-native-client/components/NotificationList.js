/**
 * NotificationList Component
 * 
 * A comprehensive notification list component with:
 * - Pull-to-refresh
 * - Infinite scrolling
 * - Swipe actions (mark as read/delete)
 * - Empty states
 * - Loading states
 * - Priority-based styling
 */

import React, { useState, useCallback } from 'react';
import {
  View,
  FlatList,
  RefreshControl,
  ActivityIndicator,
  Text,
  StyleSheet,
  TouchableOpacity,
  Alert,
  Animated
} from 'react-native';
import { Swipeable } from 'react-native-gesture-handler';

import { useNotifications } from '../hooks/useNotifications';
import NotificationItem from './NotificationItem';
import EmptyNotifications from './EmptyNotifications';

const NotificationList = ({ 
  filter = 'all', // all, unread, read, urgent, high, normal
  onNotificationPress,
  showHeader = true,
  headerActions = true 
}) => {
  const {
    notifications,
    unreadCount,
    isLoading,
    isRefreshing,
    error,
    loadMore,
    refreshNotifications,
    markAsRead,
    markAllAsRead,
    deleteNotification,
    pagination,
    connectionStatus
  } = useNotifications();

  // Filter notifications based on props
  const filteredNotifications = React.useMemo(() => {
    switch (filter) {
      case 'unread':
        return notifications.filter(n => !n.isRead);
      case 'read':
        return notifications.filter(n => n.isRead);
      case 'urgent':
        return notifications.filter(n => n.priority === 'urgent');
      case 'high':
        return notifications.filter(n => n.priority === 'high');
      case 'normal':
        return notifications.filter(n => n.priority === 'normal');
      default:
        return notifications;
    }
  }, [notifications, filter]);

  /**
   * Handle notification press
   */
  const handleNotificationPress = useCallback((notification) => {
    if (onNotificationPress) {
      onNotificationPress(notification);
    }
    
    // Mark as read if unread
    if (!notification.isRead) {
      markAsRead(notification.id);
    }
  }, [onNotificationPress, markAsRead]);

  /**
   * Handle mark as read action
   */
  const handleMarkAsRead = useCallback((notification) => {
    if (!notification.isRead) {
      markAsRead(notification.id);
    }
  }, [markAsRead]);

  /**
   * Handle delete action
   */
  const handleDelete = useCallback((notification) => {
    Alert.alert(
      'Delete Notification',
      'Are you sure you want to delete this notification?',
      [
        { text: 'Cancel', style: 'cancel' },
        {
          text: 'Delete',
          style: 'destructive',
          onPress: () => deleteNotification(notification.id)
        }
      ]
    );
  }, [deleteNotification]);

  /**
   * Handle mark all as read
   */
  const handleMarkAllAsRead = useCallback(() => {
    if (unreadCount === 0) return;

    Alert.alert(
      'Mark All as Read',
      `Mark all ${unreadCount} unread notifications as read?`,
      [
        { text: 'Cancel', style: 'cancel' },
        {
          text: 'Mark All',
          onPress: () => markAllAsRead()
        }
      ]
    );
  }, [unreadCount, markAllAsRead]);

  /**
   * Render right swipe actions
   */
  const renderRightActions = useCallback((notification, progress, dragX) => {
    const actions = [];

    // Mark as read action (only for unread notifications)
    if (!notification.isRead) {
      actions.push({
        text: 'Mark Read',
        backgroundColor: '#007AFF',
        onPress: () => handleMarkAsRead(notification)
      });
    }

    // Delete action
    actions.push({
      text: 'Delete',
      backgroundColor: '#FF3B30',
      onPress: () => handleDelete(notification)
    });

    return (
      <View style={styles.swipeActions}>
        {actions.map((action, index) => (
          <TouchableOpacity
            key={index}
            style={[styles.swipeAction, { backgroundColor: action.backgroundColor }]}
            onPress={action.onPress}
          >
            <Text style={styles.swipeActionText}>{action.text}</Text>
          </TouchableOpacity>
        ))}
      </View>
    );
  }, [handleMarkAsRead, handleDelete]);

  /**
   * Render notification item with swipe actions
   */
  const renderNotificationItem = useCallback(({ item: notification }) => (
    <Swipeable
      renderRightActions={(progress, dragX) => renderRightActions(notification, progress, dragX)}
    >
      <NotificationItem
        notification={notification}
        onPress={() => handleNotificationPress(notification)}
      />
    </Swipeable>
  ), [renderRightActions, handleNotificationPress]);

  /**
   * Render list header
   */
  const renderHeader = useCallback(() => {
    if (!showHeader) return null;

    return (
      <View style={styles.header}>
        <View style={styles.headerContent}>
          <Text style={styles.headerTitle}>
            Notifications
            {unreadCount > 0 && (
              <Text style={styles.unreadBadge}> ({unreadCount})</Text>
            )}
          </Text>
          
          {/* Connection status indicator */}
          <View style={[styles.connectionIndicator, {
            backgroundColor: connectionStatus === 'connected' ? '#4CAF50' : '#FF9800'
          }]} />
        </View>

        {headerActions && unreadCount > 0 && (
          <TouchableOpacity
            style={styles.markAllButton}
            onPress={handleMarkAllAsRead}
          >
            <Text style={styles.markAllButtonText}>Mark All Read</Text>
          </TouchableOpacity>
        )}
      </View>
    );
  }, [showHeader, unreadCount, connectionStatus, headerActions, handleMarkAllAsRead]);

  /**
   * Render list footer (loading indicator)
   */
  const renderFooter = useCallback(() => {
    if (!pagination.hasNextPage || isLoading) return null;

    return (
      <View style={styles.footer}>
        <ActivityIndicator size="small" color="#007AFF" />
      </View>
    );
  }, [pagination.hasNextPage, isLoading]);

  /**
   * Render empty state
   */
  const renderEmpty = useCallback(() => {
    if (isLoading && notifications.length === 0) {
      return (
        <View style={styles.loadingContainer}>
          <ActivityIndicator size="large" color="#007AFF" />
          <Text style={styles.loadingText}>Loading notifications...</Text>
        </View>
      );
    }

    return <EmptyNotifications filter={filter} />;
  }, [isLoading, notifications.length, filter]);

  /**
   * Handle end reached (load more)
   */
  const handleEndReached = useCallback(() => {
    if (pagination.hasNextPage && !isLoading) {
      loadMore();
    }
  }, [pagination.hasNextPage, isLoading, loadMore]);

  /**
   * Key extractor
   */
  const keyExtractor = useCallback((item) => `notification-${item.id}`, []);

  if (error) {
    return (
      <View style={styles.errorContainer}>
        <Text style={styles.errorText}>Failed to load notifications</Text>
        <Text style={styles.errorSubtext}>{error}</Text>
        <TouchableOpacity
          style={styles.retryButton}
          onPress={refreshNotifications}
        >
          <Text style={styles.retryButtonText}>Retry</Text>
        </TouchableOpacity>
      </View>
    );
  }

  return (
    <View style={styles.container}>
      <FlatList
        data={filteredNotifications}
        renderItem={renderNotificationItem}
        keyExtractor={keyExtractor}
        ListHeaderComponent={renderHeader}
        ListFooterComponent={renderFooter}
        ListEmptyComponent={renderEmpty}
        onEndReached={handleEndReached}
        onEndReachedThreshold={0.1}
        refreshControl={
          <RefreshControl
            refreshing={isRefreshing}
            onRefresh={refreshNotifications}
            colors={['#007AFF']}
            tintColor="#007AFF"
          />
        }
        showsVerticalScrollIndicator={false}
        removeClippedSubviews={true}
        maxToRenderPerBatch={10}
        windowSize={10}
        initialNumToRender={10}
        getItemLayout={(data, index) => ({
          length: 80, // Approximate item height
          offset: 80 * index,
          index,
        })}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#F8F9FA',
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    paddingHorizontal: 16,
    paddingVertical: 12,
    backgroundColor: '#FFFFFF',
    borderBottomWidth: 1,
    borderBottomColor: '#E0E0E0',
  },
  headerContent: {
    flexDirection: 'row',
    alignItems: 'center',
    flex: 1,
  },
  headerTitle: {
    fontSize: 20,
    fontWeight: '600',
    color: '#1A1A1A',
  },
  unreadBadge: {
    color: '#007AFF',
    fontWeight: '500',
  },
  connectionIndicator: {
    width: 8,
    height: 8,
    borderRadius: 4,
    marginLeft: 8,
  },
  markAllButton: {
    paddingHorizontal: 12,
    paddingVertical: 6,
    backgroundColor: '#007AFF',
    borderRadius: 6,
  },
  markAllButtonText: {
    color: '#FFFFFF',
    fontSize: 14,
    fontWeight: '500',
  },
  swipeActions: {
    flexDirection: 'row',
    alignItems: 'center',
  },
  swipeAction: {
    justifyContent: 'center',
    alignItems: 'center',
    width: 80,
    height: '100%',
  },
  swipeActionText: {
    color: '#FFFFFF',
    fontSize: 14,
    fontWeight: '500',
  },
  footer: {
    paddingVertical: 16,
    alignItems: 'center',
  },
  loadingContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    paddingVertical: 60,
  },
  loadingText: {
    marginTop: 12,
    fontSize: 16,
    color: '#666666',
  },
  errorContainer: {
    flex: 1,
    justifyContent: 'center',
    alignItems: 'center',
    paddingHorizontal: 32,
  },
  errorText: {
    fontSize: 18,
    fontWeight: '600',
    color: '#FF3B30',
    textAlign: 'center',
    marginBottom: 8,
  },
  errorSubtext: {
    fontSize: 14,
    color: '#666666',
    textAlign: 'center',
    marginBottom: 24,
  },
  retryButton: {
    paddingHorizontal: 24,
    paddingVertical: 12,
    backgroundColor: '#007AFF',
    borderRadius: 8,
  },
  retryButtonText: {
    color: '#FFFFFF',
    fontSize: 16,
    fontWeight: '500',
  },
});

export default NotificationList;