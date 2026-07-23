<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

trait FileUploader
{
    /**
     * Get the public path for file uploads
     * 
     * @return string The public path
     */
    protected function getPublicPath()
    {
        // Try to get the custom public path from environment variable
        $customPath = env('CUSTOM_PUBLIC_PATH');
        
        // If environment variable exists, use it
        if ($customPath) {
            return rtrim($customPath, '/');
        }
        
        // Fall back to Laravel's default public_path() function 
        // for normal Laravel installations
        return public_path();
    }
    
    /**
     * Upload a file directly to the public directory.
     * - Converts images to WebP format if Intervention Image is available
     * - Optimizes/compresses images larger than 1MB
     * - Retains image quality for better performance
     *
     * @param UploadedFile $file The uploaded file
     * @param string $subDirectory Subdirectory within images (e.g., 'news', 'departments')
     * @param string|null $oldPath Path to old file that should be deleted
     * @param int $quality Compression quality (0-100)
     * @return string Relative path to the file (for database storage)
     */
    public function uploadFile(UploadedFile $file, string $subDirectory = 'general', string $oldPath = null, int $quality = 80)
    {
        // Check if the file is an image
        $isImage = in_array(
            strtolower($file->getClientOriginalExtension()),
            ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']
        );
        
        // Check if PHP has WebP support - crucial for conversion
        $hasWebPSupport = function_exists('imagewebp');
        
        // Try to dynamically load Intervention Image if not already loaded
        $this->tryLoadInterventionImage();
        
        // Check if Intervention Image is available (both v2 and v3)
        $interventionV3 = class_exists('Intervention\Image\ImageManager') && class_exists('Intervention\Image\Drivers\Gd\Driver');
        $interventionV2 = class_exists('Intervention\Image\ImageManager') && !$interventionV3;
        $hasInterventionImage = $interventionV3 || $interventionV2;
        
        // Log support status
        Log::info('Image upload capabilities:', [
            'webp_support' => $hasWebPSupport,
            'intervention_v3' => $interventionV3,
            'intervention_v2' => $interventionV2,
            'is_image' => $isImage
        ]);
        
        // Define the directory path
        $publicPath = $this->getPublicPath();
        $directory = $publicPath . '/images/' . $subDirectory;
        
        // Create directory if it doesn't exist
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
        
        // Delete old file if it exists
        if ($oldPath) {
            $oldFilePath = $publicPath . '/' . $oldPath;
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }
        }
        
        // If it's not an image, just move the file as usual with no changes
        if (!$isImage) {
            Log::info('Not an image - skipping conversion');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            return $subDirectory . '/' . $filename;
        }
        
        // If Intervention Image is not available, use standard file upload
        if (!$hasInterventionImage) {
            Log::info('Intervention Image not available - using standard file upload');
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            return $subDirectory . '/' . $filename;
        }
        
        // For images with Intervention Image and WebP support, convert to WebP and optimize
        try {
            // Create unique filename for WebP image
            $filename = Str::random(40) . '.webp';
            $fullPath = $directory . '/' . $filename;
            
            // Log upload attempt
            Log::info('Attempting to convert image to WebP', [
                'original_extension' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'target_path' => $fullPath,
                'intervention_v3' => $interventionV3,
                'intervention_v2' => $interventionV2
            ]);
            
            // Check file size for quality settings
            $fileSize = $file->getSize();
            if ($fileSize > 2 * 1024 * 1024) { // More than 2MB
                $quality = min($quality, 70); 
                Log::info('Large image (>2MB): Using quality ' . $quality);
            } elseif ($fileSize > 1 * 1024 * 1024) { // More than 1MB
                $quality = min($quality, 75);
                Log::info('Medium image (>1MB): Using quality ' . $quality);
            } else {
                Log::info('Small image: Using default quality ' . $quality);
            }
            
            // Process with appropriate Intervention Image version
            if ($interventionV3) {
                // Intervention Image v3 approach
                $imageManagerClass = 'Intervention\Image\ImageManager';
                $driverClass = 'Intervention\Image\Drivers\Gd\Driver';
                
                // Create image manager with GD driver
                $manager = new $imageManagerClass(new $driverClass());
                
                // Load image
                $image = $manager->read($file->getPathname());
                Log::info('Image loaded successfully with v3');
                
                // Save as WebP
                $image->toWebp($quality)->save($fullPath);
                Log::info('WebP conversion successful with v3');
            } else {
                // Intervention Image v2 approach - use string class names to avoid IDE errors
                $managerClass = 'Intervention\Image\ImageManager';
                $manager = new $managerClass();
                
                // Configure with GD driver
                if (method_exists($manager, 'configure')) {
                    $manager->configure(['driver' => 'gd']);
                }
                
                // Load image using dynamic method call to avoid IDE errors
                $image = call_user_func([$manager, 'make'], $file->getPathname());
                Log::info('Image loaded successfully with v2');
                
                // For v2, we need to encode to WebP then save
                $encoded = call_user_func([$image, 'encode'], 'webp', $quality);
                call_user_func([$encoded, 'save'], $fullPath);
                Log::info('WebP conversion successful with v2');
            }
            
            // Return the relative path to store in database
            return $subDirectory . '/' . $filename;
        } catch (\Exception $e) {
            // Log the error
            Log::error('Failed to convert image to WebP', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'extension' => $file->getClientOriginalExtension()
            ]);
            
            // If conversion fails, fall back to normal file upload
            $filename = Str::random(40) . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            Log::info('Fallback file upload successful', ['filename' => $filename]);
            return $subDirectory . '/' . $filename;
        }
    }
    
    /**
     * Delete a file from the public directory.
     *
     * @param string $path Relative path to the file
     * @return bool True if file was deleted, false otherwise
     */
    public function deleteFile(string $path)
    {
        if (empty($path)) {
            return false;
        }
        
        $publicPath = $this->getPublicPath();
        
        // Check if path already starts with 'images/'
        if (strpos($path, 'images/') === 0) {
            $fullPath = $publicPath . '/' . $path;
        } else {
            $fullPath = $publicPath . '/images/' . $path;
        }
        
        if (File::exists($fullPath)) {
            return File::delete($fullPath);
        }
        
        return false;
    }
    
    /**
     * Optimize an existing image without converting it to WebP
     * Works with both Intervention Image v2 and v3
     *
     * @param string $imagePath Path to the image relative to public directory
     * @param int $quality Quality of the optimized image (0-100)
     * @return bool True if optimization succeeded, false otherwise
     */
    public function optimizeImage(string $imagePath, int $quality = 80)
    {
        if (empty($imagePath)) {
            return false;
        }
        
        // Try to dynamically load Intervention Image if not already loaded
        $this->tryLoadInterventionImage();
        
        // Check if Intervention Image is available (both v2 and v3)
        $interventionV3 = class_exists('Intervention\Image\ImageManager') && class_exists('Intervention\Image\Drivers\Gd\Driver');
        $interventionV2 = class_exists('Intervention\Image\ImageManager') && !$interventionV3;
        $hasInterventionImage = $interventionV3 || $interventionV2;
        
        if (!$hasInterventionImage) {
            Log::warning('Intervention Image not available - skipping optimization');
            return false;
        }
        
        $publicPath = $this->getPublicPath();
        
        // Check if path already starts with 'images/'
        if (strpos($imagePath, 'images/') === 0) {
            $fullPath = $publicPath . '/' . $imagePath;
        } else {
            $fullPath = $publicPath . '/images/' . $imagePath;
        }
        
        if (!File::exists($fullPath)) {
            return false;
        }
        
        // Check if the file is an image
        $extension = pathinfo($fullPath, PATHINFO_EXTENSION);
        $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
        
        if (!$isImage) {
            return false;
        }
        
        try {
            // Get file size in bytes
            $fileSize = filesize($fullPath);
            
            // Adjust quality based on file size
            if ($fileSize > 2 * 1024 * 1024) { // More than 2MB
                $quality = min($quality, 70);
            } elseif ($fileSize > 1 * 1024 * 1024) { // More than 1MB
                $quality = min($quality, 75);
            }
            
            if ($interventionV3) {
                // Intervention Image v3 approach
                $imageManagerClass = 'Intervention\Image\ImageManager';
                $driverClass = 'Intervention\Image\Drivers\Gd\Driver';
                
                // Create image manager with GD driver
                $manager = new $imageManagerClass(new $driverClass());
                
                // Load image
                $image = $manager->read($fullPath);
                
                // Save optimized image (same format)
                if ($extension === 'jpg' || $extension === 'jpeg') {
                    $image->toJpeg($quality)->save($fullPath);
                } elseif ($extension === 'png') {
                    $image->toPng($quality)->save($fullPath);
                } elseif ($extension === 'webp') {
                    $image->toWebp($quality)->save($fullPath);
                } else {
                    // For other formats, just resave with default settings
                    $image->save($fullPath);
                }
            } else {
                // Intervention Image v2 approach - use string class names to avoid IDE errors
                $managerClass = 'Intervention\Image\ImageManager';
                $manager = new $managerClass();
                
                // Configure with GD driver
                if (method_exists($manager, 'configure')) {
                    $manager->configure(['driver' => 'gd']);
                }
                
                // Load image using dynamic method call to avoid IDE errors
                $image = call_user_func([$manager, 'make'], $fullPath);
                
                // Save optimized image (same format)
                if ($extension === 'jpg' || $extension === 'jpeg') {
                    $encoded = call_user_func([$image, 'encode'], 'jpg', $quality);
                    call_user_func([$encoded, 'save'], $fullPath);
                } elseif ($extension === 'png') {
                    $encoded = call_user_func([$image, 'encode'], 'png', $quality);
                    call_user_func([$encoded, 'save'], $fullPath);
                } elseif ($extension === 'webp') {
                    $encoded = call_user_func([$image, 'encode'], 'webp', $quality);
                    call_user_func([$encoded, 'save'], $fullPath);
                } else {
                    // For other formats, just resave with default settings
                    call_user_func([$image, 'save'], $fullPath);
                }
            }
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to optimize image', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return false;
        }
    }
    
    /**
     * Try to manually load Intervention Image if it's not already loaded
     * This is helpful for DirectAdmin shared hosting environments
     * 
     * @return void
     */
    protected function tryLoadInterventionImage()
    {
        // Skip if Intervention Image is already loaded
        if (class_exists('Intervention\Image\ImageManager')) {
            return;
        }
        
        // Try different autoloader paths
        $possiblePaths = [
            // Standard Laravel path
            __DIR__ . '/../../vendor/autoload.php',
            
            // DirectAdmin paths based on correct structure
            // public_html/micheweni-pemba is the document root
            // micheweni-pemba (Laravel app) is at domain/micheweni-pemba
            $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php',
            dirname(dirname($_SERVER['DOCUMENT_ROOT'])) . '/micheweni-pemba/vendor/autoload.php',
            
            // Try to find the vendor directory
            dirname(dirname(dirname(__DIR__))) . '/vendor/autoload.php'
        ];
        
        foreach ($possiblePaths as $path) {
            if (file_exists($path)) {
                try {
                    require_once $path;
                    Log::info('Successfully loaded Intervention Image from: ' . $path);
                    return;
                } catch (\Exception $e) {
                    Log::warning('Failed to load autoloader from: ' . $path);
                }
            }
        }
        
        Log::warning('Could not find Intervention Image autoloader');
    }
} 