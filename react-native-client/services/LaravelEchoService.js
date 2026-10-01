/**
 * Laravel Echo Service for React Native
 * 
 * This service handles:
 * - WebSocket connection to Laravel backend
 * - Private channel authentication
 * - Real-time notification events
 * - Connection state management
 * - Automatic reconnection
 */

import Echo from 'laravel-echo';
import Pusher from 'pusher-js/react-native';
import AsyncStorage from '@react-native-async-storage/async-storage';

// Configure Pusher for React Native
window.Pusher = Pusher;

class LaravelEchoService {
  constructor() {
    this.echo = null;
    this.isConnected = false;
    this.isConnecting = false;
    this.userId = null;
    this.notificationChannel = null;
    this.authToken = null;
    this.listeners = {};
    this.connectionStateListeners = [];
    this.reconnectAttempts = 0;
    this.maxReconnectAttempts = 5;
    this.reconnectDelay = 5000; // 5 seconds
    this.lastNotificationId = null;
  }

  /**
   * Initialize Laravel Echo connection
   */
  async initialize(config = {}) {
    if (this.isConnecting || this.isConnected) {
      console.log('Echo service already initialized or connecting');
      return { success: true };
    }

    try {
      this.isConnecting = true;
      this.emitConnectionState('connecting');

      // Get auth token and user ID
      const authData = await this.getAuthData();
      if (!authData.token || !authData.userId) {
        throw new Error('Authentication required');
      }

      this.authToken = authData.token;
      this.userId = authData.userId;

      // Configure Echo based on your Laravel broadcasting setup
      const echoConfig = {
        broadcaster: 'pusher', // or 'reverb' if using Laravel Reverb
        key: config.pusherKey || process.env.PUSHER_APP_KEY || 'your-pusher-key',
        cluster: config.pusherCluster || process.env.PUSHER_APP_CLUSTER || 'mt1',
        forceTLS: true,
        encrypted: true,
        
        // Authentication
        auth: {
          headers: {
            Authorization: `Bearer ${this.authToken}`,
            Accept: 'application/json',
          },
        },
        
        // Authorization endpoint
        authEndpoint: config.authEndpoint || '/api/broadcasting/auth',
        
        // Connection options
        enabledTransports: ['ws', 'wss'],
        activityTimeout: 30000,
        pongTimeout: 30000,
        
        // For React Native
        enableStats: false,
        enableLogging: __DEV__,
        
        // Custom Pusher options
        pusherOptions: {
          cluster: config.pusherCluster || process.env.PUSHER_APP_CLUSTER || 'mt1',
          enabledTransports: ['ws', 'wss'],
          activityTimeout: 30000,
          pongTimeout: 30000,
        }
      };

      // If using Laravel Reverb instead of Pusher
      if (config.broadcaster === 'reverb') {
        echoConfig.broadcaster = 'reverb';
        echoConfig.key = config.reverbKey || process.env.REVERB_APP_KEY;
        echoConfig.wsHost = config.reverbHost || process.env.REVERB_HOST || 'localhost';
        echoConfig.wsPort = config.reverbPort || process.env.REVERB_PORT || 8080;
        echoConfig.wssPort = config.reverbWssPort || process.env.REVERB_WSS_PORT || 443;
        echoConfig.forceTLS = config.reverbTLS || process.env.REVERB_SCHEME === 'https';
        echoConfig.enabledTransports = ['ws', 'wss'];
      }

      // Initialize Echo
      this.echo = new Echo(echoConfig);

      // Set up connection event listeners
      this.setupConnectionListeners();

      // Connect to user's private notification channel
      await this.subscribeToNotificationChannel();

      this.isConnected = true;
      this.isConnecting = false;
      this.reconnectAttempts = 0;
      this.emitConnectionState('connected');

      console.log('Laravel Echo initialized successfully');
      return { success: true };

    } catch (error) {
      this.isConnecting = false;
      this.emitConnectionState('error', error);
      console.error('Failed to initialize Laravel Echo:', error);
      
      // Attempt reconnection
      this.scheduleReconnection();
      
      return { success: false, error: error.message };
    }
  }

  /**
   * Get authentication data
   */
  async getAuthData() {
    try {
      // Adjust these storage keys based on your app's auth implementation
      const token = await AsyncStorage.getItem('auth_token');
      const userDataStr = await AsyncStorage.getItem('user_data');
      
      let userId = null;
      if (userDataStr) {
        const userData = JSON.parse(userDataStr);
        userId = userData.id || userData.user_id;
      }

      return { token, userId };
    } catch (error) {
      console.error('Failed to get auth data:', error);
      return { token: null, userId: null };
    }
  }

  /**
   * Set up connection event listeners
   */
  setupConnectionListeners() {
    if (!this.echo || !this.echo.connector) {
      return;
    }

    const pusher = this.echo.connector.pusher;

    pusher.connection.bind('connected', () => {
      console.log('Pusher connected');
      this.isConnected = true;
      this.reconnectAttempts = 0;
      this.emitConnectionState('connected');
    });

    pusher.connection.bind('disconnected', () => {
      console.log('Pusher disconnected');
      this.isConnected = false;
      this.emitConnectionState('disconnected');
      this.scheduleReconnection();
    });

    pusher.connection.bind('error', (error) => {
      console.error('Pusher connection error:', error);
      this.isConnected = false;
      this.emitConnectionState('error', error);
      this.scheduleReconnection();
    });

    pusher.connection.bind('unavailable', () => {
      console.warn('Pusher connection unavailable');
      this.isConnected = false;
      this.emitConnectionState('unavailable');
      this.scheduleReconnection();
    });
  }

  /**
   * Subscribe to user's private notification channel
   */
  async subscribeToNotificationChannel() {
    if (!this.echo || !this.userId) {
      throw new Error('Echo not initialized or user ID missing');
    }

    const channelName = `user.${this.userId}.notifications`;
    console.log('Subscribing to channel:', channelName);

    this.notificationChannel = this.echo.private(channelName);

    // Listen for notification created events
    this.notificationChannel.listen('.notification.created', (event) => {
      this.handleNotificationCreated(event);
    });

    // Listen for notification read events  
    this.notificationChannel.listen('.notification.read', (event) => {
      this.handleNotificationRead(event);
    });

    // Listen for notification stats updates
    this.notificationChannel.listen('.notification.stats.updated', (event) => {
      this.handleNotificationStatsUpdated(event);
    });

    // Channel subscription success/error handlers
    this.notificationChannel.subscribed(() => {
      console.log('Successfully subscribed to notification channel');
    });

    this.notificationChannel.error((error) => {
      console.error('Failed to subscribe to notification channel:', error);
      this.emitConnectionState('subscription_error', error);
    });

    return this.notificationChannel;
  }

  /**
   * Handle notification created event
   */
  handleNotificationCreated(event) {
    console.log('Notification created:', event);

    // Avoid processing duplicate notifications
    if (event.id === this.lastNotificationId) {
      console.log('Duplicate notification ignored:', event.id);
      return;
    }
    this.lastNotificationId = event.id;

    const notification = {
      id: event.id,
      recipientId: event.recipient_id,
      title: event.title,
      message: event.message,
      priority: event.priority,
      priorityLabel: event.priority_label,
      priorityColor: event.priority_color,
      type: event.type,
      typeName: event.type_name,
      actionUrl: event.action_url,
      actionText: event.action_text,
      imageUrl: event.image_url,
      isRead: event.is_read,
      isDelivered: event.is_delivered,
      createdAt: event.created_at,
      timeAgo: event.time_ago,
      source: 'realtime'
    };

    // Emit to app
    this.emit('notificationCreated', notification);
    
    // Update notification list
    this.emit('notificationListUpdate', { type: 'add', notification });
  }

  /**
   * Handle notification read event
   */
  handleNotificationRead(event) {
    console.log('Notification read:', event);

    const readEvent = {
      notificationId: event.notification_id,
      recipientId: event.recipient_id,
      isRead: event.is_read,
      readAt: event.read_at,
      unreadCount: event.unread_count,
      source: 'realtime'
    };

    // Emit to app
    this.emit('notificationRead', readEvent);
    
    // Update notification list
    this.emit('notificationListUpdate', { 
      type: 'read', 
      notificationId: event.notification_id,
      unreadCount: event.unread_count
    });
  }

  /**
   * Handle notification stats updated event
   */
  handleNotificationStatsUpdated(event) {
    console.log('Notification stats updated:', event);

    const statsUpdate = {
      unreadCount: event.unread_count,
      urgentCount: event.urgent_count,
      timestamp: event.timestamp,
      source: 'realtime'
    };

    // Emit to app
    this.emit('notificationStatsUpdated', statsUpdate);
    
    // Update badge count
    this.emit('badgeCountUpdate', statsUpdate.unreadCount);
  }

  /**
   * Schedule reconnection attempt
   */
  scheduleReconnection() {
    if (this.reconnectAttempts >= this.maxReconnectAttempts) {
      console.log('Max reconnection attempts reached');
      this.emitConnectionState('max_reconnects_reached');
      return;
    }

    const delay = this.reconnectDelay * Math.pow(2, this.reconnectAttempts); // Exponential backoff
    this.reconnectAttempts++;

    console.log(`Scheduling reconnection attempt ${this.reconnectAttempts} in ${delay}ms`);

    setTimeout(async () => {
      if (!this.isConnected && !this.isConnecting) {
        console.log(`Reconnection attempt ${this.reconnectAttempts}`);
        await this.reconnect();
      }
    }, delay);
  }

  /**
   * Reconnect to Laravel Echo
   */
  async reconnect() {
    try {
      // Disconnect existing connection
      this.disconnect();
      
      // Wait a bit before reconnecting
      await new Promise(resolve => setTimeout(resolve, 1000));
      
      // Re-initialize
      await this.initialize();
      
    } catch (error) {
      console.error('Reconnection failed:', error);
      this.scheduleReconnection();
    }
  }

  /**
   * Disconnect from Laravel Echo
   */
  disconnect() {
    try {
      if (this.notificationChannel) {
        this.notificationChannel.stopListening('.notification.created');
        this.notificationChannel.stopListening('.notification.read'); 
        this.notificationChannel.stopListening('.notification.stats.updated');
        this.notificationChannel = null;
      }

      if (this.echo) {
        this.echo.disconnect();
        this.echo = null;
      }

      this.isConnected = false;
      this.isConnecting = false;
      this.userId = null;
      this.authToken = null;
      
      this.emitConnectionState('disconnected');
      console.log('Laravel Echo disconnected');

    } catch (error) {
      console.error('Error during disconnect:', error);
    }
  }

  /**
   * Update auth token (when user logs in with different account)
   */
  async updateAuth(newToken, newUserId) {
    this.authToken = newToken;
    const oldUserId = this.userId;
    this.userId = newUserId;

    // If user changed, need to reconnect to get new channel
    if (oldUserId !== newUserId && this.isConnected) {
      console.log('User changed, reconnecting...');
      await this.reconnect();
    }
  }

  /**
   * Get connection status
   */
  getConnectionStatus() {
    return {
      isConnected: this.isConnected,
      isConnecting: this.isConnecting,
      userId: this.userId,
      reconnectAttempts: this.reconnectAttempts,
      hasChannel: !!this.notificationChannel
    };
  }

  /**
   * Emit connection state changes
   */
  emitConnectionState(state, data = null) {
    this.connectionStateListeners.forEach(callback => {
      callback(state, data);
    });
  }

  /**
   * Add connection state listener
   */
  onConnectionStateChange(callback) {
    this.connectionStateListeners.push(callback);
    
    // Return unsubscribe function
    return () => {
      this.connectionStateListeners = this.connectionStateListeners.filter(
        cb => cb !== callback
      );
    };
  }

  /**
   * Simple event emitter
   */
  emit(event, data) {
    if (this.listeners[event]) {
      this.listeners[event].forEach(callback => callback(data));
    }
  }

  /**
   * Add event listener
   */
  on(event, callback) {
    if (!this.listeners[event]) {
      this.listeners[event] = [];
    }
    this.listeners[event].push(callback);

    // Return unsubscribe function
    return () => {
      if (this.listeners[event]) {
        this.listeners[event] = this.listeners[event].filter(cb => cb !== callback);
      }
    };
  }

  /**
   * Remove event listener
   */
  off(event, callback) {
    if (this.listeners[event]) {
      this.listeners[event] = this.listeners[event].filter(cb => cb !== callback);
    }
  }

  /**
   * Remove all listeners for an event
   */
  removeAllListeners(event) {
    if (event) {
      delete this.listeners[event];
    } else {
      this.listeners = {};
    }
  }

  /**
   * Force reconnection
   */
  async forceReconnect() {
    console.log('Force reconnecting...');
    this.reconnectAttempts = 0; // Reset attempts
    await this.reconnect();
  }
}

// Export singleton instance
export default new LaravelEchoService();

// Usage example:
/*
import LaravelEchoService from './services/LaravelEchoService';

// In your App.js or main component after authentication
export default function App() {
  const [connectionStatus, setConnectionStatus] = useState('disconnected');
  const [unreadCount, setUnreadCount] = useState(0);

  useEffect(() => {
    const initializeEcho = async () => {
      // Initialize after user authentication
      const result = await LaravelEchoService.initialize({
        pusherKey: 'your-pusher-key',
        pusherCluster: 'mt1',
        authEndpoint: '/api/broadcasting/auth'
      });
      
      if (!result.success) {
        console.error('Failed to initialize Echo:', result.error);
      }
    };

    initializeEcho();

    // Set up connection state listener
    const unsubscribeConnectionState = LaravelEchoService.onConnectionStateChange(
      (state, data) => {
        setConnectionStatus(state);
        console.log('Connection state:', state, data);
      }
    );

    // Set up notification listeners
    const unsubscribeNotificationCreated = LaravelEchoService.on(
      'notificationCreated',
      (notification) => {
        console.log('New notification:', notification);
        // Show in-app notification, update state, etc.
      }
    );

    const unsubscribeStatsUpdated = LaravelEchoService.on(
      'notificationStatsUpdated',
      (stats) => {
        setUnreadCount(stats.unreadCount);
        // Update badge count
        PushNotificationService.updateBadge(stats.unreadCount);
      }
    );

    const unsubscribeBadgeUpdate = LaravelEchoService.on(
      'badgeCountUpdate',
      (count) => {
        setUnreadCount(count);
        PushNotificationService.updateBadge(count);
      }
    );

    return () => {
      // Cleanup
      unsubscribeConnectionState();
      unsubscribeNotificationCreated();
      unsubscribeStatsUpdated();
      unsubscribeBadgeUpdate();
    };
  }, []);

  return (
    <View>
      <Text>Connection: {connectionStatus}</Text>
      <Text>Unread: {unreadCount}</Text>
      {/* Your app content */}
    </View>
  );
}

// When user logs out
const handleLogout = async () => {
  LaravelEchoService.disconnect();
  // Continue with logout process
};

// When user logs in with different account
const handleLogin = async (newToken, newUserId) => {
  await LaravelEchoService.updateAuth(newToken, newUserId);
};
*/