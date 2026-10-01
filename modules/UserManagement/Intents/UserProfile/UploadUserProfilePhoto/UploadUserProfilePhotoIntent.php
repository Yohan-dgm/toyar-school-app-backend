<?php

namespace Modules\UserManagement\Intents\UserProfile\UploadUserProfilePhoto;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\UserProfileImage;

class UploadUserProfilePhotoIntent
{
    use AsAction;

    public function handle(Request $request)
    {
        \Log::info('Profile image upload started', [
            'user_id' => $request->user()?->id,
            'has_file' => $request->hasFile('profile_image'),
            'request_method' => $request->method(),
            'content_type' => $request->header('Content-Type'),
        ]);

        DB::beginTransaction();
        try {
            // 1. Authorization - User must be authenticated via AuthGuard middleware
            $user = $request->user();
            
            \Log::info('Profile image upload - user authenticated', [
                'user_id' => $user?->id,
                'user_email' => $user?->email,
            ]);
            
            // 2. User Data Validation
            \Log::info('Profile image upload - validating request data', [
                'has_profile_image_file' => $request->hasFile('profile_image'),
                'request_files' => array_keys($request->allFiles()),
            ]);

            // Fix: Pass the uploaded file directly, not as part of array
            $validationData = [
                'profile_image' => $request->file('profile_image')
            ];
            
            $uploadUserProfilePhotoUserDTO = UploadUserProfilePhotoUserDTO::from($validationData);

            // 3. Before Intent - Check if user already has profile images
            $existingImagesCount = UserProfileImage::forUser($user->id)->count();
            
            // 4. Business Rules Validation
            // Optional: Add business rules like maximum number of profile images per user
            // For now, we allow unlimited uploads but only one active at a time

            // Action 1: Upload and store profile image
            $actionData = [];
            $actionData['user_id'] = $user->id;
            $profileImage = UploadUserProfilePhotoAction::run($validationData, $actionData);

            DB::commit();
            
            // After Intent - Log successful upload
            \Log::info('Profile image uploaded successfully', [
                'user_id' => $user->id,
                'profile_image_id' => $profileImage->id,
                'filename' => $profileImage->filename,
                'file_size' => $profileImage->file_size,
            ]);

            // Return Response
            return UploadUserProfilePhotoResDTO::fromModel($profileImage);
            
        } catch (\Throwable $th) {
            DB::rollback();
            
            // Log the error
            \Log::error('Profile image upload failed', [
                'user_id' => $request->user()?->id,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            
            throw $th;
        }
    }

    public function asController(Request $request): JsonResponse
    {
        try {
            $result = $this->handle($request);
            
            return response()->json([
                "status" => "successful",
                "message" => "Profile image uploaded successfully",
                "data" => $result,
                "metadata" => [
                    "is_system_update_pending" => false,
                    "user_id" => $request->user()->id,
                    "upload_timestamp" => now()->format('Y-m-d H:i:s'),
                    "file_info" => [
                        "size_formatted" => $result->file_size_formatted,
                        "dimensions" => $result->dimensions_string,
                        "format" => strtoupper($result->file_format)
                    ]
                ],
            ], 201);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                "status" => "failed",
                "message" => "Validation failed",
                "data" => null,
                "metadata" => [
                    "is_system_update_pending" => false
                ],
                "errors" => $e->errors(),
            ], 422);
            
        } catch (\Exception $e) {
            // Log detailed error information
            \Log::error('Profile image upload failed in controller', [
                'user_id' => $request->user()?->id,
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_class' => get_class($e),
                'request_data' => [
                    'has_file' => $request->hasFile('profile_image'),
                    'file_size' => $request->hasFile('profile_image') ? $request->file('profile_image')->getSize() : null,
                    'file_mime' => $request->hasFile('profile_image') ? $request->file('profile_image')->getMimeType() : null,
                ],
                'trace' => $e->getTraceAsString()
            ]);

            // In development, expose more details
            if (config('app.debug')) {
                return response()->json([
                    "status" => "failed", 
                    "message" => "Upload failed: " . $e->getMessage(),
                    "data" => null,
                    "metadata" => [
                        "is_system_update_pending" => false,
                        "debug_info" => [
                            "error" => $e->getMessage(),
                            "file" => $e->getFile() . ':' . $e->getLine(),
                            "type" => get_class($e)
                        ]
                    ],
                ], 500);
            }

            // Don't expose internal errors to client in production
            return response()->json([
                "status" => "failed", 
                "message" => "An error occurred while uploading the profile image. Please try again.",
                "data" => null,
                "metadata" => [
                    "is_system_update_pending" => false
                ],
            ], 500);
        }
    }
}