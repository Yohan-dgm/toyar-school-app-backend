<?php

namespace Modules\CommunicationManagement\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;

class PushConfigurationService
{
    /**
     * Validate all required push notification configurations
     */
    public function validateConfiguration(): array
    {
        $results = [
            'valid' => true,
            'errors' => [],
            'warnings' => [],
            'services' => []
        ];

        $pushService = config('push-notifications.default', 'expo');
        
        // Validate selected service
        switch ($pushService) {
            case 'expo':
                $results['services']['expo'] = $this->validateExpoConfig();
                break;
            case 'fcm':
                $results['services']['fcm'] = $this->validateFcmConfig();
                break;
            case 'apns':
                $results['services']['apns'] = $this->validateApnsConfig();
                break;
            case 'mixed':
                $results['services']['expo'] = $this->validateExpoConfig();
                $results['services']['fcm'] = $this->validateFcmConfig();
                $results['services']['apns'] = $this->validateApnsConfig();
                break;
            default:
                $results['errors'][] = "Invalid push service: {$pushService}";
                $results['valid'] = false;
        }

        // Validate broadcasting configuration
        $results['services']['broadcast'] = $this->validateBroadcastConfig();

        // Check overall validity
        foreach ($results['services'] as $service => $config) {
            if (!$config['valid']) {
                $results['valid'] = false;
                $results['errors'] = array_merge($results['errors'], $config['errors']);
            }
            $results['warnings'] = array_merge($results['warnings'], $config['warnings']);
        }

        return $results;
    }

    /**
     * Validate Expo push notification configuration
     */
    private function validateExpoConfig(): array
    {
        $result = ['valid' => true, 'errors' => [], 'warnings' => []];

        $accessToken = config('push-notifications.services.expo.access_token');
        $projectId = config('push-notifications.services.expo.project_id');

        if (empty($accessToken)) {
            $result['errors'][] = 'Expo access token is not configured (EXPO_ACCESS_TOKEN)';
            $result['valid'] = false;
        } elseif (!$this->isValidExpoToken($accessToken)) {
            $result['errors'][] = 'Expo access token format is invalid';
            $result['valid'] = false;
        }

        if (empty($projectId)) {
            $result['warnings'][] = 'Expo project ID is not configured (EXPO_PROJECT_ID)';
        }

        // Test Expo API connectivity
        if ($result['valid']) {
            try {
                $this->testExpoConnectivity($accessToken);
                $result['status'] = 'Expo API connectivity: OK';
            } catch (\Exception $e) {
                $result['warnings'][] = 'Expo API connectivity test failed: ' . $e->getMessage();
            }
        }

        return $result;
    }

    /**
     * Validate FCM configuration
     */
    private function validateFcmConfig(): array
    {
        $result = ['valid' => true, 'errors' => [], 'warnings' => []];

        $serverKey = config('push-notifications.services.fcm.server_key');
        $projectId = config('push-notifications.services.fcm.project_id');
        $serviceAccount = config('push-notifications.services.fcm.service_account');

        if (empty($serverKey)) {
            $result['errors'][] = 'FCM server key is not configured (FCM_SERVER_KEY)';
            $result['valid'] = false;
        }

        if (empty($projectId)) {
            $result['errors'][] = 'FCM project ID is not configured (FCM_PROJECT_ID)';
            $result['valid'] = false;
        }

        if (empty($serviceAccount['private_key'])) {
            $result['errors'][] = 'FCM service account private key is not configured (FCM_PRIVATE_KEY)';
            $result['valid'] = false;
        }

        if (empty($serviceAccount['client_email'])) {
            $result['errors'][] = 'FCM service account client email is not configured (FCM_CLIENT_EMAIL)';
            $result['valid'] = false;
        }

        return $result;
    }

    /**
     * Validate APNs configuration
     */
    private function validateApnsConfig(): array
    {
        $result = ['valid' => true, 'errors' => [], 'warnings' => []];

        $keyId = config('push-notifications.services.apns.key_id');
        $teamId = config('push-notifications.services.apns.team_id');
        $bundleId = config('push-notifications.services.apns.bundle_id');
        $privateKeyPath = config('push-notifications.services.apns.private_key_path');

        if (empty($keyId)) {
            $result['errors'][] = 'APNs key ID is not configured (APNS_KEY_ID)';
            $result['valid'] = false;
        }

        if (empty($teamId)) {
            $result['errors'][] = 'APNs team ID is not configured (APNS_TEAM_ID)';
            $result['valid'] = false;
        }

        if (empty($bundleId)) {
            $result['errors'][] = 'APNs bundle ID is not configured (APNS_BUNDLE_ID)';
            $result['valid'] = false;
        }

        if (empty($privateKeyPath)) {
            $result['errors'][] = 'APNs private key path is not configured (APNS_PRIVATE_KEY_PATH)';
            $result['valid'] = false;
        } elseif (!file_exists($privateKeyPath)) {
            $result['errors'][] = "APNs private key file not found: {$privateKeyPath}";
            $result['valid'] = false;
        } elseif (!is_readable($privateKeyPath)) {
            $result['errors'][] = "APNs private key file is not readable: {$privateKeyPath}";
            $result['valid'] = false;
        }

        return $result;
    }

    /**
     * Validate broadcasting configuration
     */
    private function validateBroadcastConfig(): array
    {
        $result = ['valid' => true, 'errors' => [], 'warnings' => []];

        $driver = config('broadcasting.default');
        
        if ($driver === 'null') {
            $result['warnings'][] = 'Broadcasting is disabled (using null driver)';
            return $result;
        }

        switch ($driver) {
            case 'reverb':
                $appId = config('broadcasting.connections.reverb.app_id');
                $key = config('broadcasting.connections.reverb.key');
                $secret = config('broadcasting.connections.reverb.secret');
                $host = config('broadcasting.connections.reverb.options.host');
                $port = config('broadcasting.connections.reverb.options.port');

                if (empty($appId)) {
                    $result['errors'][] = 'Reverb app ID is not configured (REVERB_APP_ID)';
                    $result['valid'] = false;
                }

                if (empty($key)) {
                    $result['errors'][] = 'Reverb app key is not configured (REVERB_APP_KEY)';
                    $result['valid'] = false;
                }

                if (empty($secret)) {
                    $result['errors'][] = 'Reverb app secret is not configured (REVERB_APP_SECRET)';
                    $result['valid'] = false;
                }

                if (empty($host)) {
                    $result['warnings'][] = 'Reverb host is not configured (REVERB_HOST)';
                }

                if (empty($port)) {
                    $result['warnings'][] = 'Reverb port is not configured (REVERB_PORT)';
                }

                break;

            case 'pusher':
                $appId = config('broadcasting.connections.pusher.app_id');
                $key = config('broadcasting.connections.pusher.key');
                $secret = config('broadcasting.connections.pusher.secret');

                if (empty($appId) || empty($key) || empty($secret)) {
                    $result['errors'][] = 'Pusher credentials are not fully configured';
                    $result['valid'] = false;
                }
                break;

            default:
                $result['warnings'][] = "Unknown broadcasting driver: {$driver}";
        }

        return $result;
    }

    /**
     * Get configuration health status
     */
    public function getHealthStatus(): array
    {
        $validation = $this->validateConfiguration();
        
        return [
            'status' => $validation['valid'] ? 'healthy' : 'unhealthy',
            'timestamp' => now()->toISOString(),
            'services' => [
                'push_notifications' => $validation['valid'] && count($validation['errors']) === 0,
                'broadcasting' => $validation['services']['broadcast']['valid'] ?? false,
            ],
            'error_count' => count($validation['errors']),
            'warning_count' => count($validation['warnings']),
            'details' => $validation
        ];
    }

    /**
     * Get configuration summary for dashboard
     */
    public function getConfigurationSummary(): array
    {
        $pushService = config('push-notifications.default', 'expo');
        $broadcastDriver = config('broadcasting.default', 'null');
        
        return [
            'push_service' => $pushService,
            'broadcast_driver' => $broadcastDriver,
            'services_configured' => $this->getConfiguredServices(),
            'health_status' => $this->getHealthStatus()['status'],
            'last_checked' => now()->toISOString()
        ];
    }

    /**
     * Get list of configured services
     */
    private function getConfiguredServices(): array
    {
        $services = [];
        
        if (!empty(config('push-notifications.services.expo.access_token'))) {
            $services[] = 'expo';
        }
        
        if (!empty(config('push-notifications.services.fcm.server_key'))) {
            $services[] = 'fcm';
        }
        
        if (!empty(config('push-notifications.services.apns.key_id'))) {
            $services[] = 'apns';
        }
        
        return $services;
    }

    /**
     * Validate Expo token format
     */
    private function isValidExpoToken(string $token): bool
    {
        return preg_match('/^[\w\-]+$/', $token) === 1;
    }

    /**
     * Test Expo API connectivity
     */
    private function testExpoConnectivity(string $accessToken): void
    {
        // This is a basic connectivity test
        // In production, you might want to make an actual API call
        if (empty($accessToken) || strlen($accessToken) < 10) {
            throw new \Exception('Invalid access token format');
        }
    }

    /**
     * Generate configuration report
     */
    public function generateConfigurationReport(): string
    {
        $validation = $this->validateConfiguration();
        $summary = $this->getConfigurationSummary();
        
        $report = "# Push Notification Configuration Report\n\n";
        $report .= "**Generated:** " . now()->format('Y-m-d H:i:s') . "\n";
        $report .= "**Status:** " . ($validation['valid'] ? '✅ Valid' : '❌ Invalid') . "\n\n";
        
        $report .= "## Summary\n";
        $report .= "- **Push Service:** " . $summary['push_service'] . "\n";
        $report .= "- **Broadcast Driver:** " . $summary['broadcast_driver'] . "\n";
        $report .= "- **Services Configured:** " . implode(', ', $summary['services_configured']) . "\n\n";
        
        if (!empty($validation['errors'])) {
            $report .= "## Errors (" . count($validation['errors']) . ")\n";
            foreach ($validation['errors'] as $error) {
                $report .= "- ❌ {$error}\n";
            }
            $report .= "\n";
        }
        
        if (!empty($validation['warnings'])) {
            $report .= "## Warnings (" . count($validation['warnings']) . ")\n";
            foreach ($validation['warnings'] as $warning) {
                $report .= "- ⚠️ {$warning}\n";
            }
            $report .= "\n";
        }
        
        $report .= "## Service Details\n";
        foreach ($validation['services'] as $service => $details) {
            $status = $details['valid'] ? '✅' : '❌';
            $report .= "- **{$service}:** {$status}\n";
        }
        
        return $report;
    }

    /**
     * Log configuration status
     */
    public function logConfigurationStatus(): void
    {
        $health = $this->getHealthStatus();
        
        if ($health['status'] === 'healthy') {
            Log::info('Push notification configuration is healthy', $health);
        } else {
            Log::warning('Push notification configuration has issues', $health);
        }
    }
}