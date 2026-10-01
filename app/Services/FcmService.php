<?php

namespace App\Services;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FcmService
{
    protected string $credentialsFilePath;

    public function __construct()
    {
        $this->credentialsFilePath = storage_path('app/firebase-auth.json');
    }

    /**
     * Generate an OAuth 2.0 Access Token using the Google Auth library.
     */
    protected function getAccessToken(): string
    {
        $scopes = ['https://www.googleapis.com/auth/firebase.messaging'];
        
        $credentials = new ServiceAccountCredentials(
            $scopes, 
            $this->credentialsFilePath
        );
        
        $tokenInfo = $credentials->fetchAuthToken();
        
        return $tokenInfo['access_token'];
    }

    /**
     * Get the Firebase Project ID from the Service Account JSON file.
     */
    protected function getProjectId(): string
    {
        if (!file_exists($this->credentialsFilePath)) {
            throw new \Exception("Firebase credentials file not found at: {$this->credentialsFilePath}");
        }

        $credentials = json_decode(file_get_contents($this->credentialsFilePath), true);
        
        if (!isset($credentials['project_id'])) {
            throw new \Exception("project_id not found in Firebase credentials file.");
        }

        return $credentials['project_id'];
    }

    /**
     * Send a Push Notification to a specific FCM Token.
     */
    public function sendNotification(string $fcmToken, string $title, string $body, array $data = [])
    {
        try {
            $accessToken = $this->getAccessToken();
            $projectId = $this->getProjectId();

            $url = "https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send";

            // Construct standard FCM HTTP v1 payload
            $messagePayload = [
                'message' => [
                    'token' => $fcmToken,
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                    ],
                ]
            ];

            // Attach data if present, ensuring values are strings
            if (!empty($data)) {
                $stringData = [];
                foreach ($data as $key => $value) {
                    $stringData[(string)$key] = (string)$value;
                }
                $messagePayload['message']['data'] = $stringData;
            }

            $response = Http::withToken($accessToken)
                ->post($url, $messagePayload);

            if ($response->successful()) {
                Log::info('FCM Notification sent successfully', ['token' => $fcmToken]);
                return $response->json();
            }

            Log::error('FCM Send Notification Failed', [
                'status' => $response->status(),
                'response' => $response->json(),
                'fcm_token' => $fcmToken,
            ]);

            return false;

        } catch (\Exception $e) {
            Log::error('FCM Service Exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return false;
        }
    }
}
