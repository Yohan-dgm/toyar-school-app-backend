/**
 * NotificationBadge Component
 * 
 * A reusable badge component for showing notification counts
 * Used in tab bars, headers, and other UI elements
 */

import React from 'react';
import {
  View,
  Text,
  StyleSheet
} from 'react-native';

const NotificationBadge = ({
  count = 0,
  maxCount = 99,
  size = 'medium', // small, medium, large
  color = '#FF3B30',
  textColor = '#FFFFFF',
  style = {},
  showZero = false
}) => {
  // Don't render if count is 0 and showZero is false
  if (count === 0 && !showZero) {
    return null;
  }

  // Format count (e.g., 99+ for counts over maxCount)
  const displayCount = count > maxCount ? `${maxCount}+` : count.toString();

  // Get size styles
  const getSizeStyle = () => {
    switch (size) {
      case 'small':
        return {
          minWidth: 16,
          height: 16,
          borderRadius: 8,
          paddingHorizontal: 4,
        };
      case 'large':
        return {
          minWidth: 28,
          height: 28,
          borderRadius: 14,
          paddingHorizontal: 8,
        };
      case 'medium':
      default:
        return {
          minWidth: 20,
          height: 20,
          borderRadius: 10,
          paddingHorizontal: 6,
        };
    }
  };

  // Get text size
  const getTextSize = () => {
    switch (size) {
      case 'small':
        return 10;
      case 'large':
        return 14;
      case 'medium':
      default:
        return 12;
    }
  };

  const sizeStyle = getSizeStyle();
  const fontSize = getTextSize();

  return (
    <View
      style={[
        styles.container,
        sizeStyle,
        { backgroundColor: color },
        style
      ]}
    >
      <Text
        style={[
          styles.text,
          { color: textColor, fontSize }
        ]}
        numberOfLines={1}
      >
        {displayCount}
      </Text>
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    justifyContent: 'center',
    alignItems: 'center',
    backgroundColor: '#FF3B30',
    position: 'absolute',
    top: -8,
    right: -8,
  },
  text: {
    color: '#FFFFFF',
    fontWeight: '600',
    textAlign: 'center',
  },
});

export default NotificationBadge;

// Usage examples:
/*

// In a tab bar
<View style={{ position: 'relative' }}>
  <TabIcon name="notifications" />
  <NotificationBadge count={unreadCount} />
</View>

// In a header
<TouchableOpacity style={{ position: 'relative' }}>
  <Icon name="bell" size={24} />
  <NotificationBadge 
    count={urgentCount} 
    size="small"
    color="#FF9500"
  />
</TouchableOpacity>

// Custom styling
<NotificationBadge
  count={totalNotifications}
  size="large"
  color="#4CAF50"
  style={{
    position: 'relative',
    top: 0,
    right: 0,
    margin: 8
  }}
/>

*/