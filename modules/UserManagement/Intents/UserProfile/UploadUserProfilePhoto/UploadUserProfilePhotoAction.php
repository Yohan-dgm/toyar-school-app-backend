<?php

namespace Modules\UserManagement\Intents\UserProfile\UploadUserProfilePhoto;

use Lorisleiva\Actions\Concerns\AsAction;
use Modules\UserManagement\Models\UserProfileImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class UploadUserProfilePhotoAction
{
    use AsAction;
    
    // Target file size configuration (in bytes)
    private const TARGET_MIN_SIZE = 204800;  // 200KB
    private const TARGET_MAX_SIZE = 512000;  // 500KB
    private const MAX_QUALITY = 85;          // Starting quality
    private const MIN_QUALITY = 50;          // Minimum acceptable quality
    private const MAX_DIMENSION = 1200;      // Increased from 800px for larger target sizes
    private const MAX_COMPRESSION_ITERATIONS = 5;

    public function handle($payloadArray, $actionData)
    {
        // User Data Validation - create DTO from payload
        $uploadUserProfilePhotoUserDTO = UploadUserProfilePhotoUserDTO::from($payloadArray);

        // Get the uploaded file
        $uploadedFile = $uploadUserProfilePhotoUserDTO->profile_image;
        
        // Define storage path (on public disk)
        $storagePath = 'nexis-college/profile_images';
        
        // Force all profile images to be JPEG for consistency and better compression
        $extension = 'jpg';
        $filename = $this->getUniqueFileName("user_{$actionData['user_id']}", $storagePath, $extension);
        $fullPath = $storagePath . '/' . $filename;
        
        try {
            // Store the file on public disk
            \Log::info('About to store file', [
                'storage_path' => $storagePath,
                'filename' => $filename,
                'disk' => 'public',
                'uploaded_file_size' => $uploadedFile->getSize(),
                'uploaded_file_name' => $uploadedFile->getClientOriginalName(),
                'uploaded_file_mime' => $uploadedFile->getMimeType(),
                'uploaded_file_valid' => $uploadedFile->isValid(),
                'uploaded_file_path' => $uploadedFile->getPathname(),
                'public_disk_config' => config('filesystems.disks.public'),
            ]);
            
            // Check if storage directory exists and is writable
            $fullStorageDir = Storage::disk('public')->path($storagePath);
            if (!is_dir($fullStorageDir)) {
                \Log::info('Creating storage directory', ['directory' => $fullStorageDir]);
                
                // Create directory with proper permissions
                if (!Storage::disk('public')->makeDirectory($storagePath)) {
                    // Fallback: Try creating with PHP mkdir
                    if (!mkdir($fullStorageDir, 0755, true)) {
                        throw new \Exception('Failed to create storage directory: ' . $fullStorageDir);
                    }
                }
                
                // Set proper permissions after creation
                try {
                    chmod($fullStorageDir, 0755);
                    \Log::info('Set directory permissions to 0755', ['directory' => $fullStorageDir]);
                } catch (\Exception $e) {
                    \Log::warning('Could not set directory permissions', [
                        'directory' => $fullStorageDir,
                        'error' => $e->getMessage()
                    ]);
                }
            }
            
            // Check if directory is writable, if not try to fix permissions gracefully
            if (!is_writable($fullStorageDir)) {
                \Log::warning('Storage directory not writable, attempting to fix permissions', [
                    'directory' => $fullStorageDir,
                    'current_permissions' => substr(sprintf('%o', fileperms($fullStorageDir)), -4)
                ]);
                
                $permissionFixed = false;
                
                try {
                    if (chmod($fullStorageDir, 0755)) {
                        clearstatcache(); // Clear file status cache
                        
                        if (is_writable($fullStorageDir)) {
                            $permissionFixed = true;
                            \Log::info('Fixed directory permissions to 0755', [
                                'directory' => $fullStorageDir
                            ]);
                        } else {
                            // Try 775 permissions if 755 doesn't work
                            if (chmod($fullStorageDir, 0775)) {
                                clearstatcache();
                                
                                if (is_writable($fullStorageDir)) {
                                    $permissionFixed = true;
                                    \Log::info('Fixed directory permissions to 0775', [
                                        'directory' => $fullStorageDir
                                    ]);
                                }
                            }
                        }
                    }
                } catch (\Exception $e) {
                    \Log::warning('chmod failed (web server lacks permission)', [
                        'directory' => $fullStorageDir,
                        'error' => $e->getMessage()
                    ]);
                }
                
                // If permission fix failed, try fallback directory
                if (!$permissionFixed && !is_writable($fullStorageDir)) {
                    \Log::info('Attempting fallback to temp storage directory');
                    
                    // Try using a temporary directory as fallback
                    $tempStoragePath = 'temp-uploads/profile_images';
                    $tempFullStorageDir = Storage::disk('public')->path($tempStoragePath);
                    
                    // Create temp directory if it doesn't exist
                    if (!is_dir($tempFullStorageDir)) {
                        try {
                            if (!Storage::disk('public')->makeDirectory($tempStoragePath)) {
                                mkdir($tempFullStorageDir, 0755, true);
                            }
                        } catch (\Exception $e) {
                            // If temp directory creation also fails, throw helpful error
                            $helpMessage = "Storage directory is not writable and temp directory creation failed. Please run these commands on your server:\n\n";
                            $helpMessage .= "sudo chown -R www-data:www-data " . dirname($fullStorageDir, 2) . "\n";
                            $helpMessage .= "sudo chmod -R 755 " . dirname($fullStorageDir, 2) . "\n";
                            $helpMessage .= "sudo php artisan storage:fix-permissions\n\n";
                            $helpMessage .= "Or contact your system administrator to fix permissions for: " . $fullStorageDir;
                            
                            throw new \Exception($helpMessage);
                        }
                    }
                    
                    // Check if temp directory is writable
                    if (is_writable($tempFullStorageDir)) {
                        \Log::info('Using fallback temp storage directory', [
                            'original_path' => $fullStorageDir,
                            'temp_path' => $tempFullStorageDir
                        ]);
                        
                        // Update storage path to use temp directory
                        $storagePath = $tempStoragePath;
                        $fullStorageDir = $tempFullStorageDir;
                        $fullPath = $storagePath . '/' . $filename;
                        
                        \Log::warning('File stored in temporary directory due to permission issues', [
                            'temp_storage_path' => $storagePath,
                            'message' => 'Please fix main storage permissions and move files from temp directory'
                        ]);
                        
                    } else {
                        // Both main and temp directories are not writable
                        $helpMessage = "Storage directory is not writable and temp directory fallback failed. Please run these commands on your server:\n\n";
                        $helpMessage .= "sudo chown -R www-data:www-data " . dirname($fullStorageDir, 2) . "\n";
                        $helpMessage .= "sudo chmod -R 755 " . dirname($fullStorageDir, 2) . "\n";
                        $helpMessage .= "sudo php artisan storage:fix-permissions\n\n";
                        $helpMessage .= "Or contact your system administrator to fix permissions for: " . $fullStorageDir;
                        
                        throw new \Exception($helpMessage);
                    }
                }
            }
            
            \Log::info('Storage directory validated', [
                'directory' => $fullStorageDir,
                'exists' => is_dir($fullStorageDir),
                'writable' => is_writable($fullStorageDir),
            ]);
            
            // Process and compress image using Intervention Image
            try {
                // Create Image Manager with GD driver
                $manager = new ImageManager(new Driver());
                
                // Get original file information
                $originalSize = $uploadedFile->getSize();
                $originalMimeType = $uploadedFile->getMimeType();
                
                \Log::info('Processing uploaded image', [
                    'original_filename' => $uploadedFile->getClientOriginalName(),
                    'original_size' => $originalSize,
                    'original_mime_type' => $originalMimeType,
                ]);
                
                // Create image from uploaded file
                $image = $manager->read($uploadedFile->getPathname());
                
                // Get original dimensions
                $originalWidth = $image->width();
                $originalHeight = $image->height();
                
                // Use iterative compression to achieve target file size
                $compressionResult = $this->compressToTargetSize($image, $originalWidth, $originalHeight);
                
                $fileContent = $compressionResult['content'];
                $width = $compressionResult['width'];
                $height = $compressionResult['height'];
                $finalQuality = $compressionResult['quality'];
                $iterations = $compressionResult['iterations'];
                
                \Log::info('Target-based compression completed', [
                    'original_size' => $originalSize,
                    'compressed_size' => strlen($fileContent),
                    'compression_ratio' => round((1 - (strlen($fileContent) / $originalSize)) * 100, 2) . '%',
                    'target_range' => self::TARGET_MIN_SIZE . '-' . self::TARGET_MAX_SIZE . ' bytes',
                    'target_achieved' => $this->isWithinTargetRange(strlen($fileContent)),
                    'final_dimensions' => "{$width}x{$height}",
                    'final_quality' => $finalQuality . '%',
                    'compression_iterations' => $iterations
                ]);
                
                // Store using Storage::put() for more reliable storage
                $storedPath = $fullPath;
                $storageSuccess = false;
                
                try {
                    $storageSuccess = Storage::disk('public')->put($storedPath, $fileContent);
                    
                    \Log::info('Storage::put executed', [
                        'success' => $storageSuccess,
                        'stored_path' => $storedPath,
                    ]);
                    
                } catch (\Exception $storageException) {
                    \Log::warning('Storage::put failed, checking if it\'s a permission issue', [
                        'error' => $storageException->getMessage(),
                        'stored_path' => $storedPath,
                    ]);
                    
                    // If storage failed, check if it's due to permission issues and try fallback
                    if (!is_writable($fullStorageDir)) {
                        \Log::info('Storage failed due to permission issues, trying fallback');
                        
                        // Try fallback temp directory
                        $tempStoragePath = 'temp-uploads/profile_images';
                        $tempFullStorageDir = Storage::disk('public')->path($tempStoragePath);
                        
                        // Create temp directory if it doesn't exist
                        if (!is_dir($tempFullStorageDir)) {
                            try {
                                if (!Storage::disk('public')->makeDirectory($tempStoragePath)) {
                                    mkdir($tempFullStorageDir, 0755, true);
                                }
                            } catch (\Exception $e) {
                                throw new \Exception('Storage failed and temp directory creation failed: ' . $storageException->getMessage());
                            }
                        }
                        
                        // Try storing in temp directory
                        if (is_writable($tempFullStorageDir)) {
                            $tempStoredPath = $tempStoragePath . '/' . $filename;
                            
                            try {
                                $storageSuccess = Storage::disk('public')->put($tempStoredPath, $fileContent);
                                if ($storageSuccess) {
                                    $storedPath = $tempStoredPath;
                                    $fullStorageDir = $tempFullStorageDir;
                                    
                                    \Log::warning('File stored in temporary directory due to permission issues', [
                                        'original_path' => $fullPath,
                                        'temp_path' => $storedPath,
                                        'message' => 'Please fix main storage permissions and move files from temp directory'
                                    ]);
                                }
                            } catch (\Exception $tempStorageException) {
                                throw new \Exception('Storage failed in both main and temp directories: ' . $storageException->getMessage() . ' | ' . $tempStorageException->getMessage());
                            }
                        }
                    }
                    
                    // If still failed after trying fallback, throw original error
                    if (!$storageSuccess) {
                        throw $storageException;
                    }
                }
                
                if (!$storageSuccess) {
                    throw new \Exception('Storage::put returned false');
                }
                
            } catch (\Exception $storeException) {
                \Log::error('Image processing or storage failed', [
                    'error' => $storeException->getMessage(),
                    'file' => $storeException->getFile() . ':' . $storeException->getLine(),
                    'original_filename' => $uploadedFile->getClientOriginalName() ?? 'unknown',
                    'original_size' => $uploadedFile->getSize() ?? 'unknown',
                ]);
                throw new \Exception('Image processing failed: ' . $storeException->getMessage());
            }
            
            // Verify file actually exists on disk
            if (!Storage::disk('public')->exists($storedPath)) {
                throw new \Exception('File storage failed - file does not exist after storage: ' . $storedPath);
            }
            
            // Verify file size matches expected content size
            $storedFileSize = Storage::disk('public')->size($storedPath);
            $expectedSize = strlen($fileContent);
            if ($storedFileSize !== $expectedSize) {
                Storage::disk('public')->delete($storedPath); // Clean up incomplete file
                throw new \Exception('File storage failed - size mismatch. Expected: ' . $expectedSize . ', Got: ' . $storedFileSize);
            }
            
            \Log::info('File stored successfully', [
                'stored_path' => $storedPath,
                'file_exists' => Storage::disk('public')->exists($storedPath),
                'stored_file_size' => $storedFileSize,
                'original_file_size' => $uploadedFile->getSize(),
                'full_storage_path' => Storage::disk('public')->path($storedPath),
            ]);
            
            \Log::info('Image processing completed', [
                'width' => $width,
                'height' => $height,
                'filename' => $filename,
            ]);
            
            // System Data Prep - Build complete file path
            $completeFilePath = 'public/' . $storedPath;
            
            // Validate file path construction
            if (empty($storedPath) || $completeFilePath === 'public/' || !str_contains($completeFilePath, $filename)) {
                throw new \Exception('Invalid file path constructed: ' . $completeFilePath . ' (stored path: ' . $storedPath . ')');
            }
            
            \Log::info('File path constructed', [
                'stored_path' => $storedPath,
                'complete_file_path' => $completeFilePath,
                'filename' => $filename,
            ]);
            
            $system_data = [
                'user_id' => $actionData['user_id'],
                'file_path' => $completeFilePath,
                'filename' => $uploadedFile->getClientOriginalName(), // Keep original filename for reference
                'file_format' => $extension, // Always 'jpg' now
                'file_size' => strlen($fileContent), // Use compressed file size
                'mime_type' => 'image/jpeg', // Always JPEG after compression
                'width' => $width,
                'height' => $height,
                'is_active' => true,
                'created_by' => $actionData['user_id'],
            ];

            // System Data Validation
            $uploadUserProfilePhotoSystemDTO = UploadUserProfilePhotoSystemDTO::from($system_data);

            // Final Data Validation
            $uploadUserProfilePhotoDTO = UploadUserProfilePhotoDTO::from($system_data);

            // Database transaction
            return DB::transaction(function () use ($uploadUserProfilePhotoDTO, $actionData) {
                // Deactivate all existing profile images for this user
                UserProfileImage::deactivateUserImages($uploadUserProfilePhotoDTO->user_id);
                
                // Create new profile image record
                $profileImage = UserProfileImage::create([
                    'user_id' => $uploadUserProfilePhotoDTO->user_id,
                    'file_path' => $uploadUserProfilePhotoDTO->file_path,
                    'filename' => $uploadUserProfilePhotoDTO->filename,
                    'file_format' => $uploadUserProfilePhotoDTO->file_format,
                    'file_size' => $uploadUserProfilePhotoDTO->file_size,
                    'mime_type' => $uploadUserProfilePhotoDTO->mime_type,
                    'width' => $uploadUserProfilePhotoDTO->width,
                    'height' => $uploadUserProfilePhotoDTO->height,
                    'is_active' => $uploadUserProfilePhotoDTO->is_active,
                    'created_by' => $uploadUserProfilePhotoDTO->created_by,
                ]);

                return $profileImage->fresh();
            });
            
        } catch (\Exception $e) {
            // If any operation fails, clean up uploaded file
            if (isset($storedPath) && !empty($storedPath) && Storage::disk('public')->exists($storedPath)) {
                \Log::info('Cleaning up stored file due to error', ['file_path' => $storedPath]);
                Storage::disk('public')->delete($storedPath);
            }
            
            \Log::error('Profile image upload failed', [
                'user_id' => $actionData['user_id'] ?? 'unknown',
                'filename' => $filename ?? 'unknown',
                'storage_path' => $storagePath ?? 'unknown',
                'stored_path' => $storedPath ?? 'not_set',
                'error_message' => $e->getMessage(),
                'error_class' => get_class($e),
                'error_file' => $e->getFile() . ':' . $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Re-throw with more context
            throw new \Exception('Profile image upload failed: ' . $e->getMessage(), 0, $e);
        }
    }

    /**
     * Generate unique filename using microtime for guaranteed uniqueness
     */
    private function getUniqueFileName($prefix, $storagePath, $extension)
    {
        $count = 1;
        $filename = "";
        
        if (is_null($extension)) {
            $extension = "";
        }
        
        do {
            if ($count == 1) {
                $filename = $prefix . '-' . microtime(true) . '.' . $extension;
            } else {
                $filename = $prefix . '-' . microtime(true) . '_' . $count . '.' . $extension;
            }
            $count++;
            
            $fullPath = Storage::disk('public')->path($storagePath . '/' . $filename);
            
        } while (Storage::disk('public')->exists($storagePath . '/' . $filename));
        
        return $filename;
    }
    
    /**
     * Compress image to target size range using smart iterative approach
     */
    private function compressToTargetSize($image, $originalWidth, $originalHeight)
    {
        $bestResult = null;
        $bestSizeDifference = PHP_INT_MAX;
        $iterations = 0;
        
        // Strategy 1: Try to find a combination that hits the target range exactly
        $dimensionOptions = $this->getDimensionOptions($originalWidth, $originalHeight);
        
        foreach ($dimensionOptions as $dimensions) {
            $qualityOptions = $this->getQualityOptions();
            
            foreach ($qualityOptions as $quality) {
                $iterations++;
                
                // Clone image for this iteration
                $testImage = clone $image;
                
                // Resize if needed
                if ($dimensions['resize']) {
                    if ($originalWidth > $originalHeight) {
                        $testImage->scale(width: $dimensions['max']);
                    } else {
                        $testImage->scale(height: $dimensions['max']);
                    }
                }
                
                // Compress with current quality
                $compressed = (string) $testImage->toJpeg($quality);
                $compressedSize = strlen($compressed);
                
                \Log::debug('Compression iteration', [
                    'iteration' => $iterations,
                    'dimensions' => $testImage->width() . 'x' . $testImage->height(),
                    'quality' => $quality,
                    'size' => $compressedSize,
                    'size_kb' => round($compressedSize / 1024, 1),
                    'target_min_kb' => round(self::TARGET_MIN_SIZE / 1024, 1),
                    'target_max_kb' => round(self::TARGET_MAX_SIZE / 1024, 1),
                ]);
                
                // Check if within target range
                if ($this->isWithinTargetRange($compressedSize)) {
                    \Log::info('Target range achieved', [
                        'size' => $compressedSize,
                        'size_kb' => round($compressedSize / 1024, 1),
                        'quality' => $quality,
                        'dimensions' => $testImage->width() . 'x' . $testImage->height(),
                        'iterations' => $iterations
                    ]);
                    
                    return [
                        'content' => $compressed,
                        'width' => $testImage->width(),
                        'height' => $testImage->height(),
                        'quality' => $quality,
                        'iterations' => $iterations,
                        'size' => $compressedSize
                    ];
                }
                
                // Track best result (closest to target range)
                $sizeDifference = $this->getDistanceFromTargetRange($compressedSize);
                if ($sizeDifference < $bestSizeDifference) {
                    $bestSizeDifference = $sizeDifference;
                    $bestResult = [
                        'content' => $compressed,
                        'width' => $testImage->width(),
                        'height' => $testImage->height(),
                        'quality' => $quality,
                        'iterations' => $iterations,
                        'size' => $compressedSize
                    ];
                }
                
                // Early exit if we found something very close to minimum target
                if ($compressedSize >= self::TARGET_MIN_SIZE * 0.8) {
                    break 2; // Close enough to target
                }
                
                // Stop if we've hit max iterations
                if ($iterations >= self::MAX_COMPRESSION_ITERATIONS) {
                    break 2;
                }
            }
        }
        
        // Strategy 2: If we couldn't hit target range, try to get as close as possible to minimum
        if ($bestResult && $bestResult['size'] < self::TARGET_MIN_SIZE) {
            \Log::warning('Could not achieve minimum target size', [
                'best_size' => $bestResult['size'],
                'best_size_kb' => round($bestResult['size'] / 1024, 1),
                'target_min_kb' => round(self::TARGET_MIN_SIZE / 1024, 1),
                'using_best_result' => true
            ]);
        }
        
        return $bestResult;
    }
    
    /**
     * Get dimension options for compression attempts
     * Start with larger dimensions to reach target file size
     */
    private function getDimensionOptions($originalWidth, $originalHeight)
    {
        $options = [];
        
        // Strategy: Start with larger dimensions to achieve target file size
        // Option 1: Use maximum allowed dimensions first
        $options[] = ['max' => self::MAX_DIMENSION, 'resize' => true];
        
        // Option 2: Keep original dimensions if reasonable
        if ($originalWidth <= self::MAX_DIMENSION && $originalHeight <= self::MAX_DIMENSION) {
            $options[] = ['max' => max($originalWidth, $originalHeight), 'resize' => false];
        }
        
        // Option 3: Try medium size if still too small
        $options[] = ['max' => 1000, 'resize' => true];
        
        // Option 4: Smaller dimensions as last resort
        $options[] = ['max' => 800, 'resize' => true];
        
        return $options;
    }
    
    /**
     * Get quality options for compression attempts
     * Start with higher quality to reach target file size
     */
    private function getQualityOptions()
    {
        return [95, self::MAX_QUALITY, 75, 65, self::MIN_QUALITY];
    }
    
    /**
     * Check if size is within target range
     */
    private function isWithinTargetRange($size)
    {
        return $size >= self::TARGET_MIN_SIZE && $size <= self::TARGET_MAX_SIZE;
    }
    
    /**
     * Get distance from target range (0 if within range)
     */
    private function getDistanceFromTargetRange($size)
    {
        if ($size < self::TARGET_MIN_SIZE) {
            return self::TARGET_MIN_SIZE - $size;
        } elseif ($size > self::TARGET_MAX_SIZE) {
            return $size - self::TARGET_MAX_SIZE;
        }
        return 0; // Within range
    }
}