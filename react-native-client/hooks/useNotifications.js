/**
 * Custom hook for notification state management
 * 
 * This hook provides:
 * - Notification list state management
 * - Real-time updates via Laravel Echo
 * - Badge count management
 * - Notification CRUD operations
 * - Optimistic updates
 */

import { useState, useEffect, useCallback, useRef } from 'react';
import { AppState } from 'react-native';

import LaravelEchoService from '../services/LaravelEchoService';
import PushNotificationService from '../services/PushNotificationService';
import ApiService from '../services/ApiService';

export const useNotifications = () => {
  // State
  const [notifications, setNotifications] = useState([]);
  const [unreadCount, setUnreadCount] = useState(0);
  const [urgentCount, setUrgentCount] = useState(0);
  const [isLoading, setIsLoading] = useState(false);
  const [isRefreshing, setIsRefreshing] = useState(false);
  const [error, setError] = useState(null);
  const [isInitialized, setIsInitialized] = useState(false);

  // Pagination state
  const [pagination, setPagination] = useState({
    page: 1,
    perPage: 20,
    hasNextPage: false,
    total: 0
  });

  // Connection state
  const [connectionStatus, setConnectionStatus] = useState('disconnected');
  
  // Refs for cleanup
  const unsubscribeRefs = useRef([]);
  const appStateRef = useRef(AppState.currentState);

  /**
   * Initialize notifications system
   */
  const initialize = useCallback(async () => {
    if (isInitialized) return;

    try {
      setIsLoading(true);
      setError(null);

      // Initialize services
      await PushNotificationService.initialize();
      await LaravelEchoService.initialize();

      // Load initial notifications
      await loadNotifications(true);

      // Set up real-time listeners
      setupRealtimeListeners();

      // Set up app state listener
      setupAppStateListener();

      setIsInitialized(true);

    } catch (error) {
      console.error('Failed to initialize notifications:', error);
      setError(error.message);
    } finally {
      setIsLoading(false);
    }
  }, [isInitialized]);

  /**
   * Set up real-time event listeners
   */
  const setupRealtimeListeners = useCallback(() => {
    // Connection state listener
    const unsubscribeConnection = LaravelEchoService.onConnectionStateChange(
      (state, data) => {
        setConnectionStatus(state);
        if (state === 'connected' && notifications.length === 0) {
          loadNotifications(true);
        }
      }
    );

    // Notification created listener
    const unsubscribeCreated = LaravelEchoService.on('notificationCreated', (notification) => {
      console.log('Real-time notification created:', notification);
      
      // Add to notifications list (optimistic update)
      setNotifications(prev => [notification, ...prev]);
      
      // Update counts
      setUnreadCount(prev => prev + 1);
      if (notification.priority === 'urgent') {
        setUrgentCount(prev => prev + 1);
      }

      // Update badge
      PushNotificationService.updateBadge(unreadCount + 1);
    });

    // Notification read listener
    const unsubscribeRead = LaravelEchoService.on('notificationRead', (readEvent) => {
      console.log('Real-time notification read:', readEvent);
      
      // Update notification in list
      setNotifications(prev => 
        prev.map(notification => 
          notification.id === readEvent.notificationId
            ? { ...notification, isRead: true, readAt: readEvent.readAt }
            : notification
        )
      );

      // Update counts
      setUnreadCount(readEvent.unreadCount);
    });

    // Stats updated listener
    const unsubscribeStats = LaravelEchoService.on('notificationStatsUpdated', (stats) => {
      console.log('Real-time stats updated:', stats);
      
      setUnreadCount(stats.unreadCount);
      setUrgentCount(stats.urgentCount);
      
      // Update badge
      PushNotificationService.updateBadge(stats.unreadCount);
    });

    // Push notification listeners (for foreground notifications)
    const unsubscribePushReceived = PushNotificationService.on('notificationReceived', (notification) => {
      console.log('Push notification received in foreground:', notification);
      // Real-time update should handle this, but we can show in-app notification here
    });

    const unsubscribePushTapped = PushNotificationService.on('notificationTapped', (notification) => {
      console.log('Push notification tapped:', notification);
      handleNotificationTap(notification);
    });

    // Store unsubscribe functions
    unsubscribeRefs.current = [
      unsubscribeConnection,
      unsubscribeCreated,
      unsubscribeRead,
      unsubscribeStats,
      unsubscribePushReceived,
      unsubscribePushTapped
    ];
  }, [notifications.length, unreadCount]);

  /**
   * Set up app state listener for background/foreground transitions
   */
  const setupAppStateListener = useCallback(() => {
    const handleAppStateChange = (nextAppState) => {
      if (appStateRef.current.match(/inactive|background/) && nextAppState === 'active') {
        console.log('App came to foreground, refreshing notifications...');
        refreshNotifications();
      }
      appStateRef.current = nextAppState;
    };

    const subscription = AppState.addEventListener('change', handleAppStateChange);
    
    return () => subscription?.remove();
  }, []);

  /**
   * Load notifications from API
   */
  const loadNotifications = useCallback(async (reset = false, filters = {}) => {
    try {
      if (reset) {
        setIsLoading(true);
        setPagination(prev => ({ ...prev, page: 1 }));
      }

      const page = reset ? 1 : pagination.page;
      
      const response = await ApiService.post('/communication-management/notifications/list', {
        page,
        per_page: pagination.perPage,
        ...filters
      });

      if (response.success) {
        const newNotifications = response.data.notifications || [];
        
        if (reset) {
          setNotifications(newNotifications);
        } else {
          setNotifications(prev => [...prev, ...newNotifications]);
        }

        setPagination({
          page: response.data.current_page || page,
          perPage: response.data.per_page || pagination.perPage,
          hasNextPage: response.data.has_next_page || false,
          total: response.data.total || 0
        });

        // Update counts from response
        if (response.data.unread_count !== undefined) {
          setUnreadCount(response.data.unread_count);
        }
        if (response.data.urgent_count !== undefined) {
          setUrgentCount(response.data.urgent_count);
        }

        return { success: true, data: response.data };
      } else {
        throw new Error(response.message || 'Failed to load notifications');
      }

    } catch (error) {
      console.error('Failed to load notifications:', error);
      setError(error.message);
      return { success: false, error: error.message };
    } finally {
      setIsLoading(false);
    }
  }, [pagination.page, pagination.perPage]);

  /**
   * Load more notifications (pagination)
   */
  const loadMore = useCallback(async () => {
    if (!pagination.hasNextPage || isLoading) return;

    setPagination(prev => ({ ...prev, page: prev.page + 1 }));
    await loadNotifications(false);
  }, [pagination.hasNextPage, isLoading, loadNotifications]);

  /**
   * Refresh notifications (pull-to-refresh)
   */
  const refreshNotifications = useCallback(async () => {
    setIsRefreshing(true);
    await loadNotifications(true);
    setIsRefreshing(false);
  }, [loadNotifications]);

  /**
   * Mark notification as read
   */
  const markAsRead = useCallback(async (notificationId, optimistic = true) => {
    try {
      // Optimistic update
      if (optimistic) {
        setNotifications(prev => 
          prev.map(notification => 
            notification.id === notificationId
              ? { ...notification, isRead: true, readAt: new Date().toISOString() }
              : notification
          )
        );

        // Update unread count optimistically
        const notification = notifications.find(n => n.id === notificationId);
        if (notification && !notification.isRead) {
          setUnreadCount(prev => Math.max(0, prev - 1));
          if (notification.priority === 'urgent') {
            setUrgentCount(prev => Math.max(0, prev - 1));
          }
        }
      }

      const response = await ApiService.post('/communication-management/notifications/mark-read', {
        notification_id: notificationId
      });

      if (!response.success) {
        // Revert optimistic update
        if (optimistic) {
          setNotifications(prev => 
            prev.map(notification => 
              notification.id === notificationId
                ? { ...notification, isRead: false, readAt: null }
                : notification
            )
          );
        }
        throw new Error(response.message || 'Failed to mark as read');
      }

      return { success: true };

    } catch (error) {
      console.error('Failed to mark notification as read:', error);
      return { success: false, error: error.message };
    }
  }, [notifications]);

  /**
   * Mark all notifications as read
   */
  const markAllAsRead = useCallback(async () => {
    try {
      // Optimistic update
      setNotifications(prev => 
        prev.map(notification => ({ 
          ...notification, 
          isRead: true, 
          readAt: new Date().toISOString() 
        }))
      );
      setUnreadCount(0);
      setUrgentCount(0);

      const response = await ApiService.post('/communication-management/notifications/mark-read', {
        mark_all: true
      });

      if (!response.success) {
        throw new Error(response.message || 'Failed to mark all as read');
      }

      // Update badge
      PushNotificationService.updateBadge(0);

      return { success: true };

    } catch (error) {
      console.error('Failed to mark all as read:', error);
      // Could revert optimistic update here if needed
      return { success: false, error: error.message };
    }
  }, []);

  /**
   * Delete notification
   */
  const deleteNotification = useCallback(async (notificationId) => {
    try {
      // Optimistic update
      const notificationToDelete = notifications.find(n => n.id === notificationId);
      setNotifications(prev => prev.filter(n => n.id !== notificationId));
      
      if (notificationToDelete && !notificationToDelete.isRead) {
        setUnreadCount(prev => Math.max(0, prev - 1));
        if (notificationToDelete.priority === 'urgent') {
          setUrgentCount(prev => Math.max(0, prev - 1));
        }
      }

      const response = await ApiService.post('/communication-management/notifications/delete', {
        notification_id: notificationId
      });

      if (!response.success) {
        // Revert optimistic update
        setNotifications(prev => [...prev, notificationToDelete].sort((a, b) => 
          new Date(b.createdAt) - new Date(a.createdAt)
        ));
        throw new Error(response.message || 'Failed to delete notification');
      }

      return { success: true };

    } catch (error) {
      console.error('Failed to delete notification:', error);
      return { success: false, error: error.message };
    }
  }, [notifications]);

  /**
   * Handle notification tap (navigation)
   */
  const handleNotificationTap = useCallback(async (notification) => {
    // Mark as read if not already
    if (!notification.isRead && notification.id) {
      await markAsRead(notification.id);
    }

    // Handle navigation based on actionUrl or notification type
    if (notification.actionUrl) {
      // Parse and navigate to the URL
      console.log('Navigate to:', notification.actionUrl);
      // Implement your navigation logic here
      // e.g., navigation.navigate(parseUrl(notification.actionUrl));
    }

    return { success: true };
  }, [markAsRead]);

  /**
   * Filter notifications
   */
  const filterNotifications = useCallback(async (filters) => {
    await loadNotifications(true, filters);
  }, [loadNotifications]);

  /**
   * Get notifications by priority
   */
  const getNotificationsByPriority = useCallback((priority) => {
    return notifications.filter(n => n.priority === priority);
  }, [notifications]);

  /**
   * Get unread notifications
   */
  const getUnreadNotifications = useCallback(() => {
    return notifications.filter(n => !n.isRead);
  }, [notifications]);

  /**
   * Cleanup when component unmounts
   */
  useEffect(() => {
    return () => {
      // Cleanup all listeners
      unsubscribeRefs.current.forEach(unsubscribe => {
        if (typeof unsubscribe === 'function') {
          unsubscribe();
        }
      });
      unsubscribeRefs.current = [];
    };
  }, []);

  return {
    // State
    notifications,
    unreadCount,
    urgentCount,
    isLoading,
    isRefreshing,
    error,
    isInitialized,
    pagination,
    connectionStatus,

    // Actions
    initialize,
    loadNotifications,
    loadMore,
    refreshNotifications,
    markAsRead,
    markAllAsRead,
    deleteNotification,
    handleNotificationTap,
    filterNotifications,

    // Computed
    getNotificationsByPriority,
    getUnreadNotifications,
    
    // Utils
    clearError: () => setError(null)
  };
};