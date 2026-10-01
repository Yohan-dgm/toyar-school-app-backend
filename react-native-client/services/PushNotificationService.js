/**
 * Push Notification Service for React Native + Expo
 * 
 * This service handles:
 * - Push notification permissions
 * - Token registration with Laravel backend
 * - Notification listeners (foreground/background)
 * - Token refresh and cleanup
 */

import * as Notifications from 'expo-notifications';
import * as Device from 'expo-device';
import { Platform } from 'react-native';
import Constants from 'expo-constants';
import AsyncStorage from '@react-native-async-storage/async-storage';

import ApiService from './ApiService'; // Assuming you have an API service

// Storage keys
const STORAGE_KEYS = {
  PUSH_TOKEN: 'push_token',
  DEVICE_ID: 'device_id',
  TOKEN_REGISTERED: 'token_registered',
  PERMISSION_REQUESTED: 'permission_requested',
};

class PushNotificationService {
  constructor() {
    this.token = null;
    this.deviceId = null;
    this.notificationListener = null;
    this.responseListener = null;
    this.isInitialized = false;
    
    // Configure notification behavior
    Notifications.setNotificationHandler({
      handleNotification: async (notification) => {
        // Determine if notification should be shown based on app state and priority
        const { data } = notification.request.content;
        const priority = data?.priority || 'normal';
        
        return {
          shouldShowAlert: true,
          shouldPlaySound: priority === 'urgent' || priority === 'high',
          shouldSetBadge: true,
          shouldShowBanner: true,
        };
      },
    });
  }

  /**
   * Initialize push notification service
   */
  async initialize() {
    if (this.isInitialized) {
      return { success: true, token: this.token };
    }

    try {
      // Check if device supports push notifications
      if (!Device.isDevice) {
        console.warn('Push notifications only work on physical devices');
        return { success: false, error: 'Physical device required' };
      }

      // Get or create device ID
      await this.initializeDeviceId();

      // Request permissions
      const permissionResult = await this.requestPermissions();
      if (!permissionResult.success) {
        return permissionResult;
      }

      // Get push token
      const tokenResult = await this.getPushToken();
      if (!tokenResult.success) {
        return tokenResult;
      }

      // Register token with backend
      const registrationResult = await this.registerTokenWithBackend();
      if (!registrationResult.success) {
        console.error('Failed to register token with backend:', registrationResult.error);
        // Continue anyway - we can retry later
      }

      // Set up notification listeners
      this.setupNotificationListeners();

      this.isInitialized = true;
      console.log('Push notification service initialized successfully');
      
      return { 
        success: true, 
        token: this.token,
        deviceId: this.deviceId 
      };

    } catch (error) {
      console.error('Failed to initialize push notification service:', error);
      return { success: false, error: error.message };
    }
  }

  /**
   * Initialize device ID (create if not exists)
   */
  async initializeDeviceId() {
    try {
      let deviceId = await AsyncStorage.getItem(STORAGE_KEYS.DEVICE_ID);
      
      if (!deviceId) {
        // Generate unique device ID
        deviceId = `${Platform.OS}-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
        await AsyncStorage.setItem(STORAGE_KEYS.DEVICE_ID, deviceId);
      }
      
      this.deviceId = deviceId;
      return deviceId;
    } catch (error) {
      console.error('Failed to initialize device ID:', error);
      throw error;
    }
  }

  /**
   * Request push notification permissions
   */
  async requestPermissions() {
    try {
      // Check if permission was already requested
      const alreadyRequested = await AsyncStorage.getItem(STORAGE_KEYS.PERMISSION_REQUESTED);
      
      const { status: existingStatus } = await Notifications.getPermissionsAsync();
      
      let finalStatus = existingStatus;
      
      // Request permission if not already granted
      if (existingStatus !== 'granted') {
        const { status } = await Notifications.requestPermissionsAsync();
        finalStatus = status;
        
        // Mark as requested
        await AsyncStorage.setItem(STORAGE_KEYS.PERMISSION_REQUESTED, 'true');
      }

      if (finalStatus !== 'granted') {
        const errorMessage = alreadyRequested 
          ? 'Push notifications are disabled. Please enable them in device settings.'
          : 'Push notification permission denied';
        
        return { success: false, error: errorMessage };
      }

      return { success: true, status: finalStatus };

    } catch (error) {
      console.error('Failed to request permissions:', error);
      return { success: false, error: error.message };
    }
  }

  /**
   * Get Expo push token
   */
  async getPushToken() {
    try {
      // Get the push token
      const tokenData = await Notifications.getExpoPushTokenAsync({
        projectId: Constants.expoConfig?.extra?.eas?.projectId,
      });

      this.token = tokenData.data;
      
      // Store token locally
      await AsyncStorage.setItem(STORAGE_KEYS.PUSH_TOKEN, this.token);
      
      console.log('Got push token:', this.token);
      return { success: true, token: this.token };

    } catch (error) {
      console.error('Failed to get push token:', error);
      return { success: false, error: error.message };
    }
  }

  /**
   * Register push token with Laravel backend
   */
  async registerTokenWithBackend() {
    if (!this.token || !this.deviceId) {
      return { success: false, error: 'Missing token or device ID' };
    }

    try {
      // Get device information
      const deviceInfo = await this.getDeviceInfo();

      const payload = {
        device_id: this.deviceId,
        push_token: this.token,
        platform: Platform.OS,
        ...deviceInfo,
      };

      console.log('Registering push token with backend...');
      const response = await ApiService.post('/user-management/push-tokens/register', payload);

      if (response.success) {
        // Mark as registered
        await AsyncStorage.setItem(STORAGE_KEYS.TOKEN_REGISTERED, 'true');
        console.log('Push token registered successfully:', response.data);
        return { success: true, data: response.data };
      } else {
        console.error('Backend registration failed:', response.message);
        return { success: false, error: response.message };
      }

    } catch (error) {
      console.error('Failed to register token with backend:', error);
      return { success: false, error: error.message };
    }
  }

  /**
   * Get device information
   */
  async getDeviceInfo() {
    try {
      return {
        app_version: Constants.expoConfig?.version || '1.0.0',
        device_name: Device.deviceName || `${Device.brand} ${Device.modelName}`,
        device_model: Device.modelName || 'Unknown',
        os_version: Device.osVersion || 'Unknown',
      };
    } catch (error) {
      console.warn('Failed to get device info:', error);
      return {
        app_version: '1.0.0',
        device_name: 'Unknown Device',
        device_model: 'Unknown',
        os_version: 'Unknown',
      };
    }
  }

  /**
   * Set up notification listeners
   */
  setupNotificationListeners() {
    // Listener for notifications received while app is in foreground
    this.notificationListener = Notifications.addNotificationReceivedListener(
      this.handleNotificationReceived.bind(this)
    );

    // Listener for when user taps notification
    this.responseListener = Notifications.addNotificationResponseReceivedListener(
      this.handleNotificationResponse.bind(this)
    );

    console.log('Notification listeners set up');
  }

  /**
   * Handle notification received (foreground)
   */
  handleNotificationReceived(notification) {
    console.log('Notification received (foreground):', notification);
    
    const { data, title, body } = notification.request.content;
    
    // Emit custom event for app to handle
    this.emit('notificationReceived', {
      id: data?.notificationId,
      title,
      message: body,
      data,
      timestamp: new Date(),
      source: 'foreground'
    });

    // Update badge count if provided
    if (data?.unreadCount) {
      Notifications.setBadgeCountAsync(parseInt(data.unreadCount));
    }
  }

  /**
   * Handle notification response (user tapped)
   */
  handleNotificationResponse(response) {
    console.log('Notification response received:', response);
    
    const { data, title, body } = response.notification.request.content;
    const actionIdentifier = response.actionIdentifier;
    
    // Emit custom event for app to handle
    this.emit('notificationTapped', {
      id: data?.notificationId,
      title,
      message: body,
      data,
      actionIdentifier,
      timestamp: new Date(),
      actionUrl: data?.actionUrl
    });

    // Clear badge if notification was tapped
    if (actionIdentifier === Notifications.DEFAULT_ACTION_IDENTIFIER) {
      this.clearBadge();
    }
  }

  /**
   * Refresh push token (call periodically)
   */
  async refreshToken() {
    try {
      console.log('Refreshing push token...');
      
      const tokenResult = await this.getPushToken();
      if (!tokenResult.success) {
        return tokenResult;
      }

      // Check if token changed
      const storedToken = await AsyncStorage.getItem(STORAGE_KEYS.PUSH_TOKEN);
      if (storedToken !== this.token) {
        console.log('Push token changed, re-registering...');
        return await this.registerTokenWithBackend();
      }

      console.log('Push token is up to date');
      return { success: true, token: this.token };

    } catch (error) {
      console.error('Failed to refresh token:', error);
      return { success: false, error: error.message };
    }
  }

  /**
   * Unregister push token (when logging out)
   */
  async unregister() {
    try {
      console.log('Unregistering push token...');

      if (this.token && this.deviceId) {
        // Delete token from backend
        await ApiService.post('/user-management/push-tokens/delete', {
          device_id: this.deviceId,
          push_token: this.token,
        });
      }

      // Clear local storage
      await AsyncStorage.multiRemove([
        STORAGE_KEYS.PUSH_TOKEN,
        STORAGE_KEYS.TOKEN_REGISTERED,
        // Keep DEVICE_ID and PERMISSION_REQUESTED for next login
      ]);

      // Remove listeners
      if (this.notificationListener) {
        Notifications.removeNotificationSubscription(this.notificationListener);
        this.notificationListener = null;
      }
      
      if (this.responseListener) {
        Notifications.removeNotificationSubscription(this.responseListener);
        this.responseListener = null;
      }

      // Reset state
      this.token = null;
      this.isInitialized = false;
      
      // Clear badge
      await this.clearBadge();

      console.log('Push token unregistered successfully');
      return { success: true };

    } catch (error) {
      console.error('Failed to unregister push token:', error);
      return { success: false, error: error.message };
    }
  }

  /**
   * Clear notification badge
   */
  async clearBadge() {
    try {
      await Notifications.setBadgeCountAsync(0);
    } catch (error) {
      console.warn('Failed to clear badge:', error);
    }
  }

  /**
   * Update badge count
   */
  async updateBadge(count) {
    try {
      await Notifications.setBadgeCountAsync(Math.max(0, parseInt(count) || 0));
    } catch (error) {
      console.warn('Failed to update badge:', error);
    }
  }

  /**
   * Simple event emitter for internal use
   */
  emit(event, data) {
    // You can replace this with your preferred event system (EventEmitter, etc.)
    if (this.listeners && this.listeners[event]) {
      this.listeners[event].forEach(callback => callback(data));
    }
  }

  /**
   * Add event listener
   */
  on(event, callback) {
    if (!this.listeners) {
      this.listeners = {};
    }
    if (!this.listeners[event]) {
      this.listeners[event] = [];
    }
    this.listeners[event].push(callback);
  }

  /**
   * Remove event listener
   */
  off(event, callback) {
    if (this.listeners && this.listeners[event]) {
      this.listeners[event] = this.listeners[event].filter(cb => cb !== callback);
    }
  }

  /**
   * Get current registration status
   */
  async getRegistrationStatus() {
    const token = await AsyncStorage.getItem(STORAGE_KEYS.PUSH_TOKEN);
    const registered = await AsyncStorage.getItem(STORAGE_KEYS.TOKEN_REGISTERED);
    const deviceId = await AsyncStorage.getItem(STORAGE_KEYS.DEVICE_ID);
    
    return {
      hasToken: !!token,
      isRegistered: registered === 'true',
      deviceId,
      token
    };
  }
}

// Export singleton instance
export default new PushNotificationService();

// Usage example:
/*
import PushNotificationService from './services/PushNotificationService';

// In your App.js or main component
export default function App() {
  useEffect(() => {
    const initializePushNotifications = async () => {
      const result = await PushNotificationService.initialize();
      if (result.success) {
        console.log('Push notifications initialized');
      } else {
        console.log('Push notifications failed:', result.error);
      }
    };

    initializePushNotifications();

    // Set up listeners
    PushNotificationService.on('notificationReceived', (notification) => {
      console.log('New notification:', notification);
      // Update your app state, show in-app notification, etc.
    });

    PushNotificationService.on('notificationTapped', (notification) => {
      console.log('Notification tapped:', notification);
      // Navigate to relevant screen based on actionUrl
      if (notification.actionUrl) {
        // Navigate to the URL or screen
      }
    });

    return () => {
      // Cleanup if needed
    };
  }, []);

  return (
    // Your app content
  );
}

// When user logs out
const handleLogout = async () => {
  await PushNotificationService.unregister();
  // Continue with logout process
};
*/