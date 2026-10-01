<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Modules\UserManagement\Models\User;
use Modules\UserManagement\Models\UserProfileImage;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ProfilePictureController extends Controller
{
    /**
     * Get user profile picture
     * If no user_id provided, returns current authenticated user's profile picture
     * If user_id provided, returns that user's profile picture
     *
     * @param  int|null  $user_id
     * @return \Illuminate\Http\Response
     */
    public function getUserProfilePicture(Request $request, $user_id = null)
    {
        try {
            // If no user_id provided, try to get current authenticated user
            if (! $user_id) {
                $user = Auth::user();
                if (! $user) {
                    return $this->getDefaultProfilePicture();
                }
                $user_id = $user->id;
            }

            // Validate user exists
            $user = User::find($user_id);
            if (! $user) {
                return $this->getDefaultProfilePicture();
            }

            // Get active profile image for the user
            $profileImage = UserProfileImage::getActiveForUser($user_id);

            if (! $profileImage) {
                return $this->getDefaultProfilePicture();
            }

            // Check if the file exists in storage
            $filePath = $profileImage->file_path;

            // Remove 'public/' prefix if present since we're using public disk
            $storagePath = str_replace('public/', '', $filePath);

            if (! Storage::disk('public')->exists($storagePath)) {
                \Log::warning('Profile image file not found', [
                    'user_id' => $user_id,
                    'file_path' => $filePath,
                    'storage_path' => $storagePath,
                ]);

                return $this->getDefaultProfilePicture();
            }

            // Get file contents
            $fileContent = Storage::disk('public')->get($storagePath);
            $mimeType = $profileImage->mime_type ?: 'image/jpeg';
            $fileSize = $profileImage->file_size ?: strlen($fileContent);

            // Create response with proper headers
            return Response::make($fileContent, 200, [
                'Content-Type' => $mimeType,
                'Content-Length' => $fileSize,
                'Content-Disposition' => 'inline; filename="profile_'.$user_id.'.'.$profileImage->file_format.'"',
                'Cache-Control' => 'public, max-age=3600', // Cache for 1 hour
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'SAMEORIGIN',
                'Last-Modified' => gmdate('D, d M Y H:i:s', strtotime($profileImage->updated_at)).' GMT',
            ]);

        } catch (\Exception $e) {
            \Log::error('Profile picture serving error', [
                'user_id' => $user_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->getDefaultProfilePicture();
        }
    }

    /**
     * Get default profile picture (placeholder)
     *
     * @return \Illuminate\Http\Response
     */
    private function getDefaultProfilePicture()
    {
        // Create a simple SVG placeholder
        $svg = '<?xml version="1.0" encoding="UTF-8"?>
        <svg width="150" height="150" viewBox="0 0 150 150" xmlns="http://www.w3.org/2000/svg">
            <rect width="150" height="150" fill="#e5e7eb"/>
            <circle cx="75" cy="60" r="25" fill="#9ca3af"/>
            <path d="M30 120 Q30 100 50 100 L100 100 Q120 100 120 120 L120 150 L30 150 Z" fill="#9ca3af"/>
            <text x="75" y="140" text-anchor="middle" font-family="Arial, sans-serif" font-size="12" fill="#6b7280">No Photo</text>
        </svg>';

        return Response::make($svg, 200, [
            'Content-Type' => 'image/svg+xml',
            'Content-Length' => strlen($svg),
            'Cache-Control' => 'public, max-age=86400', // Cache for 24 hours
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    /**
     * Get profile picture info without serving the image
     *
     * @param  int|null  $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfilePictureInfo(Request $request, $user_id = null)
    {
        try {
            // If no user_id provided, try to get current authenticated user
            if (! $user_id) {
                $user = Auth::user();
                if (! $user) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No user specified and not authenticated',
                    ], HttpResponse::HTTP_BAD_REQUEST);
                }
                $user_id = $user->id;
            }

            // Validate user exists
            $user = User::find($user_id);
            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User not found',
                ], HttpResponse::HTTP_NOT_FOUND);
            }

            // Get active profile image for the user
            $profileImage = UserProfileImage::getActiveForUser($user_id);

            if (! $profileImage) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No profile picture found',
                    'data' => [
                        'has_profile_picture' => false,
                        'user_id' => $user_id,
                        'username' => $user->username ?? null,
                        'full_name' => $user->full_name ?? null,
                    ],
                ]);
            }

            // Check if file exists
            $storagePath = str_replace('public/', '', $profileImage->file_path);
            $fileExists = Storage::disk('public')->exists($storagePath);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile picture info retrieved',
                'data' => [
                    'has_profile_picture' => true,
                    'user_id' => $user_id,
                    'username' => $user->username ?? null,
                    'full_name' => $user->full_name ?? null,
                    'filename' => $profileImage->filename,
                    'file_format' => $profileImage->file_format,
                    'file_size' => $profileImage->file_size,
                    'file_size_formatted' => $profileImage->getFormattedSize(),
                    'width' => $profileImage->width,
                    'height' => $profileImage->height,
                    'dimensions' => $profileImage->getDimensionsString(),
                    'mime_type' => $profileImage->mime_type,
                    'created_at' => $profileImage->created_at,
                    'updated_at' => $profileImage->updated_at,
                    'file_exists' => $fileExists,
                    'url' => url('/get-profile-picture/'.$user_id),
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('Profile picture info error', [
                'user_id' => $user_id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error retrieving profile picture info',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Check if user has profile picture
     *
     * @param  int|null  $user_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function hasProfilePicture(Request $request, $user_id = null)
    {
        try {
            if (! $user_id) {
                $user = Auth::user();
                if (! $user) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'No user specified and not authenticated',
                    ], HttpResponse::HTTP_BAD_REQUEST);
                }
                $user_id = $user->id;
            }

            $profileImage = UserProfileImage::getActiveForUser($user_id);
            $hasProfilePicture = $profileImage !== null;

            // If profile image exists, check if file actually exists
            if ($hasProfilePicture) {
                $storagePath = str_replace('public/', '', $profileImage->file_path);
                $hasProfilePicture = Storage::disk('public')->exists($storagePath);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Profile picture status checked',
                'data' => [
                    'user_id' => $user_id,
                    'has_profile_picture' => $hasProfilePicture,
                    'url' => $hasProfilePicture ? url('/get-profile-picture/'.$user_id) : null,
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('Profile picture status check error', [
                'user_id' => $user_id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error checking profile picture status',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
