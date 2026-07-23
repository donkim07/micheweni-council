<?php
// Set error reporting to show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Intervention Image Installation Helper</h1>";

// Check if Composer autoloader is available
if (file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require __DIR__ . '/../vendor/autoload.php';
    echo "<p style='color:green'>✓ Composer autoloader found</p>";
} else {
    echo "<p style='color:red'>✗ Composer autoloader not found</p>";
    die("Cannot proceed without autoloader");
}

// Check PHP version
echo "<h2>PHP Version Check:</h2>";
$phpVersion = phpversion();
echo "<p>Current PHP version: $phpVersion</p>";

if (version_compare($phpVersion, '8.0.0', '>=')) {
    echo "<p style='color:green'>✓ PHP version is compatible with Intervention Image v3</p>";
} else {
    echo "<p style='color:orange'>⚠ PHP version is older than 8.0.0. Intervention Image v3 requires PHP 8.0+</p>";
    echo "<p>You should use Intervention Image v2 instead.</p>";
}

// Check GD extension
echo "<h2>GD Extension Check:</h2>";
if (extension_loaded('gd')) {
    echo "<p style='color:green'>✓ GD extension is installed</p>";
    
    // Get GD info
    $gdInfo = gd_info();
    echo "<ul>";
    foreach ($gdInfo as $key => $value) {
        echo "<li>";
        echo "<strong>" . htmlspecialchars($key) . ":</strong> ";
        echo htmlspecialchars($value === true ? 'Yes' : ($value === false ? 'No' : $value));
        echo "</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color:red'>✗ GD extension is NOT installed</p>";
    echo "<p>You need to install GD library before you can use Intervention Image.</p>";
}

// Check Imagick extension
echo "<h2>Imagick Extension Check:</h2>";
if (extension_loaded('imagick')) {
    echo "<p style='color:green'>✓ Imagick extension is installed</p>";
    
    // Get Imagick version
    $imagick = new Imagick();
    $version = $imagick->getVersion();
    echo "<p>Version: " . htmlspecialchars($version['versionString']) . "</p>";
} else {
    echo "<p style='color:orange'>⚠ Imagick extension is NOT installed</p>";
    echo "<p>GD will be used as the driver instead.</p>";
}

// Check WebP support
echo "<h2>WebP Support Check:</h2>";
if (function_exists('imagewebp')) {
    echo "<p style='color:green'>✓ WebP support is available</p>";
} else {
    echo "<p style='color:red'>✗ WebP support is NOT available</p>";
    echo "<p>You won't be able to convert images to WebP format.</p>";
}

// Check for Intervention Image
echo "<h2>Intervention Image Check:</h2>";

// Check for v3
$hasInterventionV3 = class_exists('Intervention\Image\ImageManager') && class_exists('Intervention\Image\Drivers\Gd\Driver');
if ($hasInterventionV3) {
    echo "<p style='color:green'>✓ Intervention Image v3 is installed</p>";
} else {
    echo "<p style='color:orange'>⚠ Intervention Image v3 is NOT installed</p>";
}

// Check for v2
$hasInterventionV2 = class_exists('Intervention\Image\ImageManager') && !$hasInterventionV3;
if ($hasInterventionV2) {
    echo "<p style='color:green'>✓ Intervention Image v2 is installed</p>";
} else {
    echo "<p style='color:orange'>⚠ Intervention Image v2 is NOT installed</p>";
}

if (!$hasInterventionV2 && !$hasInterventionV3) {
    echo "<p style='color:red'>✗ No version of Intervention Image is installed</p>";
}

// Installation instructions
echo "<h2>Installation Instructions:</h2>";

echo "<h3>Option 1: Install Intervention Image v3 (recommended for PHP 8.0+)</h3>";
echo "<pre>cd " . dirname(__DIR__) . "\ncomposer require intervention/image:^3.0</pre>";

echo "<h3>Option 2: Install Intervention Image v2 (for older PHP versions)</h3>";
echo "<pre>cd " . dirname(__DIR__) . "\ncomposer require intervention/image:^2.0</pre>";

// Test image creation
echo "<h2>Test Image Creation:</h2>";

// Try with v3 if available
if ($hasInterventionV3) {
    echo "<h3>Testing with Intervention Image v3:</h3>";
    try {
        $manager = new Intervention\Image\ImageManager(
            new Intervention\Image\Drivers\Gd\Driver()
        );
        
        // Create a simple test image
        $image = $manager->create(100, 100, '#ff0000');
        echo "<p style='color:green'>✓ Created test image</p>";
        
        // Try to output the image
        ob_start();
        echo $image->toJpeg();
        $imageData = ob_get_clean();
        echo "<p style='color:green'>✓ Generated JPEG output</p>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='Test Image'>";
        
        // Try WebP conversion if supported
        if (function_exists('imagewebp')) {
            ob_start();
            echo $image->toWebp();
            $webpData = ob_get_clean();
            echo "<p style='color:green'>✓ Generated WebP output</p>";
            echo "<img src='data:image/webp;base64," . base64_encode($webpData) . "' alt='WebP Test Image'>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>✗ Error with Intervention Image v3: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
}

// Try with v2 if available
if ($hasInterventionV2) {
    echo "<h3>Testing with Intervention Image v2:</h3>";
    try {
        $manager = new Intervention\Image\ImageManager(['driver' => 'gd']);
        
        // Create a simple test image
        $image = $manager->canvas(100, 100, '#0000ff');
        echo "<p style='color:green'>✓ Created test image with v2</p>";
        
        // Try to output the image
        $imageData = (string)$image->encode('jpg');
        echo "<p style='color:green'>✓ Generated JPEG output with v2</p>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='v2 Test Image'>";
        
        // Try WebP conversion if supported
        if (function_exists('imagewebp')) {
            $webpData = (string)$image->encode('webp');
            echo "<p style='color:green'>✓ Generated WebP output with v2</p>";
            echo "<img src='data:image/webp;base64," . base64_encode($webpData) . "' alt='v2 WebP Test Image'>";
        }
    } catch (Exception $e) {
        echo "<p style='color:red'>✗ Error with Intervention Image v2: " . $e->getMessage() . "</p>";
        echo "<pre>" . $e->getTraceAsString() . "</pre>";
    }
} 