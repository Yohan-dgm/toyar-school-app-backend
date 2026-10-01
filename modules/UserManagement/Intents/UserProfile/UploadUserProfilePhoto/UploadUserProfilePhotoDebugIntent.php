<?php

namespace Modules\UserManagement\Intents\UserProfile\UploadUserProfilePhoto;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\User;
use Modules\UserManagement\Models\UserProfileImage;

class UploadUserProfilePhotoDebugIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        // DEBUG: Only allow in development
        if (!config('app.debug')) {
            return response()->json([
                "status" => "failed",
                "message" => "Debug endpoint not available in production",
                "data" => null,
            ], 403);
        }

        \Log::info('DEBUG: Profile image upload started without auth', [
            'has_file' => $request->hasFile('profile_image'),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
            'files' => $request->allFiles(),
        ]);

        DB::beginTransaction();
        try {
            // Use test user ID (hardcoded for debug)
            $testUserId = 1;
            $user = User::find($testUserId);
            
            if (!$user) {
                return response()->json([
                    "status" => "failed",
                    "message" => "Test user not found (ID: $testUserId)",
                    "data" => null,
                ], 404);
            }

            \Log::info('DEBUG: Using test user', [
                'user_id' => $user->id,
                'user_email' => $user->email,
            ]);

            // 2. User Data Validation
            \Log::info('DEBUG: About to validate request data', [
                'request_all' => array_keys($request->all()),
                'files' => array_keys($request->allFiles()),
                'has_profile_image' => $request->hasFile('profile_image'),
            ]);

            // Fix: Pass the uploaded file directly, not as part of array
            $validationData = [
                'profile_image' => $request->file('profile_image')
            ];
            
            // Create DTO instance from validated data
            $uploadUserProfilePhotoUserDTO = UploadUserProfilePhotoUserDTO::from($validationData);

            \Log::info('DEBUG: User data validation passed', [
                'dto_type' => gettype($uploadUserProfilePhotoUserDTO),
                'dto_class' => get_class($uploadUserProfilePhotoUserDTO),
            ]);

            // Access file properties correctly
            $profileImageFile = $uploadUserProfilePhotoUserDTO->profile_image;
            \Log::info('DEBUG: File properties', [
                'file_size' => $profileImageFile->getSize(),
                'mime_type' => $profileImageFile->getMimeType(),
                'original_name' => $profileImageFile->getClientOriginalName(),
            ]);

            // 3. Before Intent - Check existing profile images
            $existingImagesCount = UserProfileImage::forUser($user->id)->count();
            
            \Log::info('DEBUG: Existing images check', [
                'existing_count' => $existingImagesCount,
            ]);

            // Action 1: Upload and store profile image
            $actionData = [];
            $actionData['user_id'] = $user->id;
            
            \Log::info('DEBUG: About to call upload action', $actionData);
            
            $profileImage = UploadUserProfilePhotoAction::run($validationData, $actionData);

            \Log::info('DEBUG: Upload action completed', [
                'profile_image_id' => $profileImage->id,
                'file_path' => $profileImage->file_path,
            ]);

            DB::commit();
            
            \Log::info('DEBUG: Transaction committed successfully');

            // Return Response
            return response()->json([
                "status" => "successful",
                "message" => "DEBUG: Profile image uploaded successfully",
                "data" => UploadUserProfilePhotoResDTO::fromModel($profileImage),
                "metadata" => [
                    "is_debug" => true,
                    "is_system_update_pending" => false,
                    "user_id" => $user->id,
                    "upload_timestamp" => now()->format('Y-m-d H:i:s'),
                ],
            ], 201);
            
        } catch (\Throwable $th) {
            DB::rollback();
            
            \Log::error('DEBUG: Profile image upload failed', [
                'error_message' => $th->getMessage(),
                'error_file' => $th->getFile(),
                'error_line' => $th->getLine(),
                'error_class' => get_class($th),
                'trace' => $th->getTraceAsString()
            ]);
            
            return response()->json([
                "status" => "failed",
                "message" => "DEBUG: Upload failed - " . $th->getMessage(),
                "data" => null,
                "metadata" => [
                    "is_debug" => true,
                    "error_details" => [
                        "message" => $th->getMessage(),
                        "file" => $th->getFile() . ':' . $th->getLine(),
                        "type" => get_class($th)
                    ]
                ],
            ], 500);
        }
    }

    public function asController(Request $request): JsonResponse
    {
        return $this->handle($request);
    }
}