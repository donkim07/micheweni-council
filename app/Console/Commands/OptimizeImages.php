<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class OptimizeImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize {--path=all : The directory path to optimize (relative to public/images)} {--webp : Convert to WebP format} {--quality=80 : Compression quality (0-100)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize images by compressing them and optionally converting to WebP format';

    /**
     * Image extensions that can be processed
     */
    protected $validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];

    /**
     * Convert to WebP flag
     */
    protected $convertToWebP = false;

    /**
     * Quality setting
     */
    protected $quality = 80;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->quality = $this->option('quality');
        $this->convertToWebP = $this->option('webp');
        $path = $this->option('path');
        
        $this->info('Starting image optimization...');

        // Get project's public path
        $publicPath = public_path();
        $baseImagePath = $publicPath . '/images';
        
        // Check if the base image directory exists
        if (!File::isDirectory($baseImagePath)) {
            $this->error('Images directory not found: ' . $baseImagePath);
            return 1;
        }
        
        // Determine which directory to process
        $directoryToProcess = $path === 'all' ? $baseImagePath : $baseImagePath . '/' . $path;
        
        if (!File::isDirectory($directoryToProcess)) {
            $this->error('Directory not found: ' . $directoryToProcess);
            return 1;
        }
        
        $this->info('Scanning directory: ' . $directoryToProcess);
        
        // Get all image files
        $files = $this->getAllImageFiles($directoryToProcess);
        $totalFiles = count($files);
        
        if ($totalFiles === 0) {
            $this->info('No images found to optimize.');
            return 0;
        }
        
        $this->info("Found {$totalFiles} images to process.");
        
        // Set up the progress bar
        $bar = $this->output->createProgressBar($totalFiles);
        $bar->start();
        
        $optimizedCount = 0;
        $errorCount = 0;
        $skippedCount = 0;
        
        // Process each image
        foreach ($files as $file) {
            try {
                // Skip if already WebP and we're converting to WebP
                if ($this->convertToWebP && pathinfo($file, PATHINFO_EXTENSION) === 'webp') {
                    $skippedCount++;
                    $bar->advance();
                    continue;
                }
                
                // Get the file size before optimization
                $originalSize = File::size($file);
                
                // Create image manager
                $manager = new ImageManager(new Driver());
                
                // Load image
                $image = $manager->read($file);
                
                // Get only filename without extension for later use
                $pathInfo = pathinfo($file);
                $filename = $pathInfo['filename'];
                $directory = $pathInfo['dirname'];
                
                // Adjust quality based on file size
                $adjustedQuality = $this->quality;
                if ($originalSize > 2 * 1024 * 1024) { // More than 2MB
                    $adjustedQuality = min($adjustedQuality, 70);
                } elseif ($originalSize > 1 * 1024 * 1024) { // More than 1MB
                    $adjustedQuality = min($adjustedQuality, 75);
                }
                
                if ($this->convertToWebP) {
                    // Save as WebP with adjusted quality
                    $newFilePath = $directory . '/' . $filename . '.webp';
                    $image->toWebp($adjustedQuality)->save($newFilePath);
                    
                    // Delete original file if the new one was created successfully
                    if (File::exists($newFilePath) && File::size($newFilePath) > 0) {
                        File::delete($file);
                    }
                } else {
                    // Optimize without format change
                    $extension = strtolower($pathInfo['extension']);
                    
                    if ($extension === 'jpg' || $extension === 'jpeg') {
                        $image->toJpeg($adjustedQuality)->save($file);
                    } elseif ($extension === 'png') {
                        $image->toPng($adjustedQuality)->save($file);
                    } elseif ($extension === 'webp') {
                        $image->toWebp($adjustedQuality)->save($file);
                    } else {
                        // For other formats, just resave
                        $image->save($file);
                    }
                }
                
                // Check file size after optimization
                if ($this->convertToWebP) {
                    $newSize = File::size($newFilePath);
                    $savingsPercent = round((($originalSize - $newSize) / $originalSize) * 100, 2);
                } else {
                    $newSize = File::size($file);
                    $savingsPercent = round((($originalSize - $newSize) / $originalSize) * 100, 2);
                }
                
                $optimizedCount++;
                
            } catch (\Exception $e) {
                $errorCount++;
            }
            
            $bar->advance();
        }
        
        $bar->finish();
        $this->newLine(2);
        
        $this->info('Optimization complete!');
        $this->info("Processed: {$totalFiles} images");
        $this->info("Optimized: {$optimizedCount} images");
        $this->info("Skipped: {$skippedCount} images");
        $this->info("Errors: {$errorCount} images");
        
        return 0;
    }
    
    /**
     * Get all image files in a directory and its subdirectories.
     *
     * @param string $directory
     * @return array
     */
    protected function getAllImageFiles($directory)
    {
        $files = [];
        
        foreach (File::allFiles($directory) as $file) {
            $extension = strtolower($file->getExtension());
            
            if (in_array($extension, $this->validExtensions)) {
                $files[] = $file->getPathname();
            }
        }
        
        return $files;
    }
}
