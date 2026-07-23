<?php

// Load composer autoloader
require __DIR__.'/../vendor/autoload.php';

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

// Make sure errors are displayed
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>Image Conversion Test</h1>";

try {
    // Create output directory if it doesn't exist
    $outputDir = __DIR__ . '/test-output';
    if (!file_exists($outputDir)) {
        mkdir($outputDir, 0755, true);
    }

    echo "<p>Testing GD extension availability: ";
    if (extension_loaded('gd')) {
        echo "<span style='color: green;'>OK</span></p>";
    } else {
        echo "<span style='color: red;'>NOT INSTALLED!</span> - GD extension is required.</p>";
        exit;
    }
    
    echo "<p>Testing WebP support in GD: ";
    if (function_exists('imagewebp')) {
        echo "<span style='color: green;'>OK</span></p>";
    } else {
        echo "<span style='color: red;'>NOT SUPPORTED!</span> - Your PHP GD installation doesn't support WebP.</p>";
        exit;
    }

    echo "<p>Testing Intervention Image package: ";
    $manager = new ImageManager(new Driver());
    echo "<span style='color: green;'>OK</span></p>";

    // Set image source (using a sample image)
    $sampleImage = __DIR__ . '/images/logo-left.png';
    if (!file_exists($sampleImage)) {
        echo "<p style='color: red;'>Sample image not found at $sampleImage</p>";
        exit;
    }

    echo "<p>Found sample image: $sampleImage</p>";
    echo "<p>Original image:</p>";
    echo "<img src='/images/logo-left.png' style='max-width: 300px;'>";
    
    // Convert to WebP
    $outputPath = $outputDir . '/test-webp.webp';
    $image = $manager->read($sampleImage);
    $image->toWebp(80)->save($outputPath);
    
    echo "<p>Successfully converted image to WebP at: $outputPath</p>";
    echo "<p>WebP image:</p>";
    echo "<img src='/test-output/test-webp.webp' style='max-width: 300px;'>";
    
    // Get file sizes for comparison
    $originalSize = filesize($sampleImage);
    $webpSize = filesize($outputPath);
    $savings = round((($originalSize - $webpSize) / $originalSize) * 100, 2);
    
    echo "<p>Original size: " . round($originalSize / 1024, 2) . " KB</p>";
    echo "<p>WebP size: " . round($webpSize / 1024, 2) . " KB</p>";
    echo "<p>Space savings: $savings%</p>";

} catch (\Exception $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    echo "<p>File: " . $e->getFile() . " (Line: " . $e->getLine() . ")</p>";
} 