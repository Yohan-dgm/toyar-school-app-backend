<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class MediaController extends Controller
{
    /**
     * Serve authenticated files from storage/app directory
     *
     * @param  string  $path  - The file path relative to storage/app/
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $path)
    {
        // Check if user is authenticated (AuthGuard middleware handles this)
        $user = Auth::user();
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], HttpResponse::HTTP_UNAUTHORIZED);
        }

        // Sanitize path to prevent directory traversal attacks
        $path = $this->sanitizePath($path);

        // Construct the full path to the file
        // Path structure: /storage/app/{path}
        $fullPath = $path;

        // Check if file exists
        if (! Storage::exists($fullPath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found',
            ], HttpResponse::HTTP_NOT_FOUND);
        }

        try {
            // Get file contents and metadata
            $file = Storage::get($fullPath);
            $mimeType = Storage::mimeType($fullPath);
            $size = Storage::size($fullPath);

            // Get filename from path
            $filename = basename($path);

            // Determine content disposition based on file type
            $disposition = 'inline'; // Default to inline for images/videos

            // For PDFs, you might want to force download or inline based on preference
            if (str_contains($mimeType, 'pdf')) {
                $disposition = 'inline'; // Change to 'attachment' to force download
            }

            // Create response with proper headers
            return Response::make($file, 200, [
                'Content-Type' => $mimeType,
                'Content-Length' => $size,
                'Content-Disposition' => $disposition.'; filename="'.$filename.'"',
                'Cache-Control' => 'private, max-age=3600', // Cache for 1 hour
                'X-Content-Type-Options' => 'nosniff',
                'X-Frame-Options' => 'SAMEORIGIN',
            ]);

        } catch (\Exception $e) {
            \Log::error('Media file serving error', [
                'path' => $path,
                'full_path' => $fullPath,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Error serving file',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Serve files from specific subdirectories (for backward compatibility)
     *
     * @param  string  $directory  - The subdirectory name
     * @param  string  $filename  - The filename
     * @return \Illuminate\Http\Response
     */
    public function showByDirectory(Request $request, $directory, $filename)
    {
        // Construct path with directory
        $path = $directory.'/'.$filename;

        // Use the main show method
        return $this->show($request, $path);
    }

    /**
     * Get media file info without downloading
     *
     * @param  string  $path
     * @return \Illuminate\Http\JsonResponse
     */
    public function info(Request $request, $path)
    {
        // Check authentication
        $user = Auth::user();
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], HttpResponse::HTTP_UNAUTHORIZED);
        }

        $fullPath = $path;

        if (! Storage::exists($fullPath)) {
            return response()->json([
                'status' => 'error',
                'message' => 'File not found',
            ], HttpResponse::HTTP_NOT_FOUND);
        }

        try {
            $mimeType = Storage::mimeType($fullPath);
            $size = Storage::size($fullPath);
            $lastModified = Storage::lastModified($fullPath);

            return response()->json([
                'status' => 'successful',
                'message' => 'File info retrieved',
                'data' => [
                    'filename' => basename($path),
                    'path' => $path,
                    'mime_type' => $mimeType,
                    'size' => $size,
                    'size_formatted' => $this->formatBytes($size),
                    'last_modified' => date('Y-m-d H:i:s', $lastModified),
                    'type' => $this->getMediaType($mimeType),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error getting file info',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision).' '.$units[$i];
    }

    /**
     * Get media type from mime type
     */
    private function getMediaType($mimeType)
    {
        if (str_contains($mimeType, 'image')) {
            return 'image';
        } elseif (str_contains($mimeType, 'video')) {
            return 'video';
        } elseif (str_contains($mimeType, 'pdf')) {
            return 'pdf';
        }

        return 'unknown';
    }

    /**
     * Sanitize file path to prevent directory traversal attacks
     */
    private function sanitizePath($path)
    {
        // Remove any attempts to traverse directories
        $path = str_replace(['../', '..\\', '../', '..\\'], '', $path);

        // Remove leading slashes
        $path = ltrim($path, '/\\');

        // Normalize path separators
        $path = str_replace('\\', '/', $path);

        return $path;
    }

    /**
     * List files in a directory (for debugging/admin purposes)
     *
     * @param  string  $directory  - Directory path relative to storage/app
     * @return \Illuminate\Http\JsonResponse
     */
    public function listDirectory(Request $request, $directory = '')
    {
        // Check authentication
        $user = Auth::user();
        if (! $user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access',
            ], HttpResponse::HTTP_UNAUTHORIZED);
        }

        // Sanitize directory path
        $directory = $this->sanitizePath($directory);

        try {
            $files = Storage::files($directory);
            $directories = Storage::directories($directory);

            $fileList = [];
            foreach ($files as $file) {
                $fileList[] = [
                    'name' => basename($file),
                    'path' => $file,
                    'type' => 'file',
                    'size' => Storage::size($file),
                    'size_formatted' => $this->formatBytes(Storage::size($file)),
                    'mime_type' => Storage::mimeType($file),
                    'last_modified' => date('Y-m-d H:i:s', Storage::lastModified($file)),
                ];
            }

            foreach ($directories as $dir) {
                $fileList[] = [
                    'name' => basename($dir),
                    'path' => $dir,
                    'type' => 'directory',
                    'size' => null,
                    'size_formatted' => null,
                    'mime_type' => null,
                    'last_modified' => null,
                ];
            }

            return response()->json([
                'status' => 'successful',
                'message' => 'Directory listing retrieved',
                'data' => [
                    'current_directory' => $directory ?: '/',
                    'items' => $fileList,
                    'total_files' => count($files),
                    'total_directories' => count($directories),
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error listing directory',
            ], HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
