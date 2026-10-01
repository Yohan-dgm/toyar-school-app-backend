<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Modules\UserManagement\Models\UserProfileImage;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class UserProfileImageController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authentication required',
                ], HttpResponse::HTTP_UNAUTHORIZED);
            }

            $profileImages = UserProfileImage::forUser($user->id)
                ->orderedByDate()
                ->get()
                ->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'filename' => $image->filename,
                        'file_format' => $image->file_format,
                        'file_size' => $image->file_size,
                        'file_size_formatted' => $image->getFormattedSize(),
                        'width' => $image->width,
                        'height' => $image->height,
                        'dimensions' => $image->getDimensionsString(),
                        'mime_type' => $image->mime_type,
                        'is_active' => $image->is_active,
                        'created_at' => $image->created_at,
                        'updated_at' => $image->updated_at,
                        'url' => url('/get-profile-picture/'.$user->id),
                    ];
                });

            return response()->json([
                'status' => 'success',
                'message' => 'Profile images retrieved successfully',
                'data' => $profileImages,
            ]);

        } catch (\Exception $e) {
            \Log::error('User profile images retrieval error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error retrieving profile images',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(Request $request, $id): JsonResponse
    {
        try {
            $user = Auth::user();
            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authentication required',
                ], HttpResponse::HTTP_UNAUTHORIZED);
            }

            $profileImage = UserProfileImage::where('id', $id)
                ->forUser($user->id)
                ->first();

            if (! $profileImage) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Profile image not found',
                ], HttpResponse::HTTP_NOT_FOUND);
            }

            $storagePath = str_replace('public/', '', $profileImage->file_path);
            $fileExists = Storage::disk('public')->exists($storagePath);

            return response()->json([
                'status' => 'success',
                'message' => 'Profile image retrieved successfully',
                'data' => [
                    'id' => $profileImage->id,
                    'filename' => $profileImage->filename,
                    'file_format' => $profileImage->file_format,
                    'file_size' => $profileImage->file_size,
                    'file_size_formatted' => $profileImage->getFormattedSize(),
                    'width' => $profileImage->width,
                    'height' => $profileImage->height,
                    'dimensions' => $profileImage->getDimensionsString(),
                    'mime_type' => $profileImage->mime_type,
                    'is_active' => $profileImage->is_active,
                    'created_at' => $profileImage->created_at,
                    'updated_at' => $profileImage->updated_at,
                    'file_exists' => $fileExists,
                    'url' => url('/get-profile-picture/'.$user->id),
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('User profile image retrieval error', [
                'user_id' => Auth::id(),
                'profile_image_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error retrieving profile image',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        try {
            $user = Auth::user();
            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authentication required',
                ], HttpResponse::HTTP_UNAUTHORIZED);
            }

            $profileImage = UserProfileImage::where('id', $id)
                ->forUser($user->id)
                ->first();

            if (! $profileImage) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Profile image not found',
                ], HttpResponse::HTTP_NOT_FOUND);
            }

            $filename = $profileImage->filename;
            $profileImage->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile image deleted successfully',
                'data' => [
                    'deleted_filename' => $filename,
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('User profile image deletion error', [
                'user_id' => Auth::id(),
                'profile_image_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error deleting profile image',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function activate(Request $request, $id): JsonResponse
    {
        try {
            $user = Auth::user();
            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authentication required',
                ], HttpResponse::HTTP_UNAUTHORIZED);
            }

            $profileImage = UserProfileImage::where('id', $id)
                ->forUser($user->id)
                ->first();

            if (! $profileImage) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Profile image not found',
                ], HttpResponse::HTTP_NOT_FOUND);
            }

            UserProfileImage::deactivateUserImages($user->id);

            $profileImage->is_active = true;
            $profileImage->updated_by = $user->id;
            $profileImage->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile image activated successfully',
                'data' => [
                    'id' => $profileImage->id,
                    'filename' => $profileImage->filename,
                    'is_active' => $profileImage->is_active,
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('User profile image activation error', [
                'user_id' => Auth::id(),
                'profile_image_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error activating profile image',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function deactivate(Request $request, $id): JsonResponse
    {
        try {
            $user = Auth::user();
            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authentication required',
                ], HttpResponse::HTTP_UNAUTHORIZED);
            }

            $profileImage = UserProfileImage::where('id', $id)
                ->forUser($user->id)
                ->first();

            if (! $profileImage) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Profile image not found',
                ], HttpResponse::HTTP_NOT_FOUND);
            }

            $profileImage->is_active = false;
            $profileImage->updated_by = $user->id;
            $profileImage->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Profile image deactivated successfully',
                'data' => [
                    'id' => $profileImage->id,
                    'filename' => $profileImage->filename,
                    'is_active' => $profileImage->is_active,
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('User profile image deactivation error', [
                'user_id' => Auth::id(),
                'profile_image_id' => $id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error deactivating profile image',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getActive(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            if (! $user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Authentication required',
                ], HttpResponse::HTTP_UNAUTHORIZED);
            }

            $profileImage = UserProfileImage::getActiveForUser($user->id);

            if (! $profileImage) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'No active profile image found',
                    'data' => null,
                ]);
            }

            $storagePath = str_replace('public/', '', $profileImage->file_path);
            $fileExists = Storage::disk('public')->exists($storagePath);

            return response()->json([
                'status' => 'success',
                'message' => 'Active profile image retrieved successfully',
                'data' => [
                    'id' => $profileImage->id,
                    'filename' => $profileImage->filename,
                    'file_format' => $profileImage->file_format,
                    'file_size' => $profileImage->file_size,
                    'file_size_formatted' => $profileImage->getFormattedSize(),
                    'width' => $profileImage->width,
                    'height' => $profileImage->height,
                    'dimensions' => $profileImage->getDimensionsString(),
                    'mime_type' => $profileImage->mime_type,
                    'is_active' => $profileImage->is_active,
                    'created_at' => $profileImage->created_at,
                    'updated_at' => $profileImage->updated_at,
                    'file_exists' => $fileExists,
                    'url' => url('/get-profile-picture/'.$user->id),
                ],
            ]);

        } catch (\Exception $e) {
            \Log::error('Active profile image retrieval error', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error retrieving active profile image',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getUserProfileImage(Request $request)
    {
        try {
            $url = $request->get('url');
            $filename = $request->get('filename');
            $mimeType = $request->get('mime_type');

            // Validate required parameters
            if (! $url || ! $filename || ! $mimeType) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Missing required parameters: url, filename, mime_type',
                ], 400);
            }

            // Build the full file path with proper handling of different URL formats
            $filePath = $url;

            // Handle different URL patterns
            if (str_starts_with($url, 'storage/public/')) {
                // Handle: storage/public/temp-uploads/...
                $relativePath = substr($url, 15); // Remove 'storage/public/'
                $filePath = storage_path('app/public/'.$relativePath);
            } elseif (str_starts_with($url, 'storage/app/public/')) {
                // Handle: storage/app/public/temp-uploads/...
                $relativePath = substr($url, 19); // Remove 'storage/app/public/'
                $filePath = storage_path('app/public/'.$relativePath);
            } elseif (str_starts_with($url, 'storage/')) {
                // Handle: storage/temp-uploads/... (assume it's relative to public)
                $relativePath = substr($url, 8); // Remove 'storage/'
                $filePath = storage_path('app/public/'.$relativePath);
            } elseif (! str_starts_with($url, '/') && ! str_starts_with($url, storage_path())) {
                // Handle relative paths: temp-uploads/profile_images/...
                $filePath = storage_path('app/public/'.ltrim($url, '/'));
            }
            // If URL starts with '/' or storage_path(), use it as-is

            // Check if file exists
            if (! file_exists($filePath)) {
                \Log::warning('User profile image file not found', [
                    'original_url' => $url,
                    'resolved_path' => $filePath,
                    'filename' => $filename,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'File not found: '.$url,
                    'debug_info' => [
                        'original_url' => $url,
                        'resolved_path' => $filePath,
                        'file_exists' => file_exists($filePath),
                    ],
                ], 404);
            }

            // Serve the file using Laravel's response()->file() method
            return response()->file($filePath, [
                'Content-Type' => urldecode($mimeType),
                'Content-Disposition' => 'inline; filename="'.$filename.'"',
                'Cache-Control' => 'public, max-age=3600',
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'SAMEORIGIN',
            ]);

        } catch (\Exception $e) {
            \Log::error('User profile image serving error', [
                'url' => $request->get('url'),
                'filename' => $request->get('filename'),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error serving profile image: '.$e->getMessage(),
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
