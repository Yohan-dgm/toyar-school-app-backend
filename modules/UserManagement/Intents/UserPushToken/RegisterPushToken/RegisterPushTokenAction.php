<?php

namespace Modules\UserManagement\Intents\UserPushToken\RegisterPushToken;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\UserPushToken;

class RegisterPushTokenAction
{
    use AsAction;

    public function handle($payloadArray, $actionData)
    {
        try {
            \Log::info('RegisterPushTokenAction starting', [
                'payload' => $payloadArray,
                'action_data' => $actionData,
            ]);

            // User Data Validation
            $registerPushTokenUserDTO = RegisterPushTokenUserDTO::validate($payloadArray);
            \Log::info('User DTO validated successfully', $registerPushTokenUserDTO);

            // System Data Prep
            $systemData = [
                'user_id' => $actionData['user_id'],
            ];

            // System Data Validation
            $registerPushTokenSystemDTO = RegisterPushTokenSystemDTO::validate($systemData);
            \Log::info('System DTO validated successfully', $registerPushTokenSystemDTO);

            // Final Data Validation
            $mergedData = array_merge($registerPushTokenUserDTO, $registerPushTokenSystemDTO);
            \Log::info('Merged data for final validation', $mergedData);
            
            $registerPushTokenDTO = RegisterPushTokenDTO::validate($mergedData);
            \Log::info('Final DTO validated successfully', $registerPushTokenDTO);

        } catch (\Exception $e) {
            \Log::error('RegisterPushTokenAction DTO validation failed', [
                'payload' => $payloadArray,
                'action_data' => $actionData,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }

        try {
            // Check if token already exists for this user and device
            \Log::info('Checking for existing token', [
                'user_id' => $registerPushTokenDTO['user_id'],
                'device_id' => $registerPushTokenDTO['device_id'],
            ]);

            $existingToken = UserPushToken::where('user_id', $registerPushTokenDTO['user_id'])
                ->where('device_id', $registerPushTokenDTO['device_id'])
                ->first();

            $wasUpdated = false;

            if ($existingToken) {
                \Log::info('Updating existing token', ['existing_token_id' => $existingToken->id]);
                
                // Update existing token
                $existingToken->updateToken(
                    $registerPushTokenDTO['push_token'],
                    [
                        'app_version' => $registerPushTokenDTO['app_version'],
                        'device_name' => $registerPushTokenDTO['device_name'],
                        'device_model' => $registerPushTokenDTO['device_model'],
                        'os_version' => $registerPushTokenDTO['os_version'],
                    ]
                );
                $token = $existingToken->fresh();
                $wasUpdated = true;
                \Log::info('Token updated successfully', ['token_id' => $token->id]);
            } else {
                \Log::info('Creating or claiming token');
                
                // First, check if this push_token exists for ANY user/device
                $existingTokenByValue = UserPushToken::where('push_token', $registerPushTokenDTO['push_token'])->first();
                
                if ($existingTokenByValue) {
                    \Log::info('Token already exists, claiming it for new user/device', [
                        'token_id' => $existingTokenByValue->id,
                        'old_user_id' => $existingTokenByValue->user_id,
                        'new_user_id' => $registerPushTokenDTO['user_id']
                    ]);
                    
                    // Claim the token: Update it to belong to this new user/device combination
                    $existingTokenByValue->update([
                        'user_id' => $registerPushTokenDTO['user_id'],
                        'device_id' => $registerPushTokenDTO['device_id'],
                        'platform' => $registerPushTokenDTO['platform'],
                        'app_version' => $registerPushTokenDTO['app_version'],
                        'device_name' => $registerPushTokenDTO['device_name'],
                        'device_model' => $registerPushTokenDTO['device_model'],
                        'os_version' => $registerPushTokenDTO['os_version'],
                        'is_active' => true,
                        'failed_deliveries' => 0,
                        'failure_reason' => null,
                        'last_used_at' => \Carbon\Carbon::now(),
                    ]);
                    
                    $token = $existingTokenByValue->fresh();
                    $wasUpdated = true;
                } else {
                    // Create completely new token
                    $token = UserPushToken::createOrUpdateToken(
                        $registerPushTokenDTO['user_id'],
                        $registerPushTokenDTO['device_id'],
                        $registerPushTokenDTO['push_token'],
                        $registerPushTokenDTO['platform'],
                        [
                            'app_version' => $registerPushTokenDTO['app_version'],
                            'device_name' => $registerPushTokenDTO['device_name'],
                            'device_model' => $registerPushTokenDTO['device_model'],
                            'os_version' => $registerPushTokenDTO['os_version'],
                        ]
                    );
                    \Log::info('New token created successfully', ['token_id' => $token->id]);
                }
            }

            // Also deactivate any other tokens for this user with the same push_token
            // This handles cases where the same token was registered from different devices
            $deactivatedCount = UserPushToken::where('push_token', $registerPushTokenDTO['push_token'])
                ->where('id', '!=', $token->id)
                ->update([
                    'is_active' => false,
                    'failure_reason' => 'Token transferred to another device',
                ]);
            
            \Log::info('Deactivated duplicate tokens', ['count' => $deactivatedCount]);

        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database error in RegisterPushTokenAction', [
                'sql_error' => $e->getMessage(),
                'error_code' => $e->getCode(),
                'bindings' => $e->getBindings(),
                'dto_data' => $registerPushTokenDTO,
            ]);
            throw $e;
        } catch (\Exception $e) {
            \Log::error('General error in RegisterPushTokenAction database operations', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'dto_data' => $registerPushTokenDTO,
            ]);
            throw $e;
        }

        // Prepare response data
        $responseData = [
            'id' => $token->id,
            'user_id' => $token->user_id,
            'device_id' => $token->device_id,
            'platform' => $token->platform,
            'is_active' => $token->is_active,
            'was_updated' => $wasUpdated,
            'created_at' => $token->created_at->toISOString(),
            'updated_at' => $token->updated_at->toISOString(),
        ];

        return RegisterPushTokenResDTO::from($responseData);
    }
}