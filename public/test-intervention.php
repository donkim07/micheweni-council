<?php
// Set error reporting to show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Intervention Image Diagnostic</h1>";

// Check if Composer autoloader is available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
    echo "<p style='color:green'>✓ Composer autoloader found</p>";
} else {
    echo "<p style='color:red'>✗ Composer autoloader not found</p>";
    die("Cannot proceed without autoloader");
}

// Check if Intervention Image classes exist
echo "<h2>Class Existence Check:</h2>";
$classes = [
    'Intervention\Image\ImageManager',
    'Intervention\Image\Drivers\Gd\Driver',
    'Intervention\Image\Drivers\Imagick\Driver'
];

foreach ($classes as $class) {
    if (class_exists($class)) {
        echo "<p style='color:green'>✓ Class exists: $class</p>";
    } else {
        echo "<p style='color:red'>✗ Class does not exist: $class</p>";
    }
}

// Try to create an ImageManager instance
echo "<h2>Creating ImageManager:</h2>";
try {
    // Try with GD driver
    echo "<h3>With GD Driver:</h3>";
    $manager = new Intervention\Image\ImageManager(
        new Intervention\Image\Drivers\Gd\Driver()
    );
    echo "<p style='color:green'>✓ Successfully created ImageManager with GD driver</p>";
    
    // Create a simple test image
    $image = $manager->create(100, 100, '#ff0000');
    echo "<p style='color:green'>✓ Created test image</p>";
    
    // Try to output the image
    ob_start();
    echo $image->toJpeg();
    $imageData = ob_get_clean();
    echo "<p style='color:green'>✓ Generated JPEG output</p>";
    echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='Test Image'>";
    
    // Try WebP conversion
    if (function_exists('imagewebp')) {
        ob_start();
        echo $image->toWebp();
        $webpData = ob_get_clean();
        echo "<p style='color:green'>✓ Generated WebP output</p>";
        echo "<img src='data:image/webp;base64," . base64_encode($webpData) . "' alt='WebP Test Image'>";
    } else {
        echo "<p style='color:red'>✗ WebP function not available</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color:red'>✗ Error creating ImageManager with GD: " . $e->getMessage() . "</p>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}

// Try with Imagick driver if available
if (extension_loaded('imagick')) {
    echo "<h3>With Imagick Driver:</h3>";
    try {
        $manager = new Intervention\Image\ImageManager(
            new Intervention\Image\Drivers\Imagick\Driver()
        );
        echo "<p style='color:green'>✓ Successfully created ImageManager with Imagick driver</p>";
        
        // Create a simple test image
        $image = $manager->create(100, 100, '#0000ff');
        echo "<p style='color:green'>✓ Created test image with Imagick</p>";
        
        // Try to output the image
        ob_start();
        echo $image->toJpeg();
        $imageData = ob_get_clean();
        echo "<p style='color:green'>✓ Generated JPEG output with Imagick</p>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='Imagick Test Image'>";
        
    } catch (Exception $e) {
        echo "<p style='color:red'>✗ Error creating ImageManager with Imagick: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
} else {
    echo "<p style='color:orange'>⚠ Imagick extension not loaded</p>";
}

// Check Intervention Image version
echo "<h2>Package Version:</h2>";
if (file_exists(__DIR__ . '/../composer.lock')) {
    $composerLock = json_decode(file_get_contents(__DIR__ . '/../composer.lock'), true);
    $interventionVersion = null;
    
    if (isset($composerLock['packages'])) {
        foreach ($composerLock['packages'] as $package) {
            if ($package['name'] === 'intervention/image') {
                $interventionVersion = $package['version'];
                break;
            }
        }
    }
    
    if ($interventionVersion) {
        echo "<p>Intervention Image version: $interventionVersion</p>";
    } else {
        echo "<p style='color:orange'>⚠ Could not determine Intervention Image version</p>";
    }
} else {
    echo "<p style='color:orange'>⚠ composer.lock not found</p>";
}

// PHP Info for debugging
echo "<h2>PHP Version and Extensions:</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";

echo "<h3>Loaded Extensions:</h3>";
echo "<ul>";
$extensions = get_loaded_extensions();
sort($extensions);
foreach ($extensions as $ext) {
    echo "<li>$ext</li>";
}
echo "</ul>"; 