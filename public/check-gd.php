<?php
echo '<h1>GD & WebP Support Check</h1>';

// Check if GD is installed
if (extension_loaded('gd')) {
    echo '<p style="color: green;">✓ GD extension is installed</p>';
    
    // Get GD info
    $gdInfo = gd_info();
    echo '<h2>GD Information:</h2>';
    echo '<ul>';
    foreach ($gdInfo as $key => $value) {
        echo '<li>';
        echo '<strong>' . htmlspecialchars($key) . ':</strong> ';
        echo htmlspecialchars($value === true ? 'Yes' : ($value === false ? 'No' : $value));
        echo '</li>';
    }
    echo '</ul>';
    
    // Check for WebP support
    if (function_exists('imagewebp')) {
        echo '<p style="color: green;">✓ WebP support is available</p>';
    } else {
        echo '<p style="color: red;">✗ WebP support is NOT available</p>';
    }
    
    // Test image creation functionality
    echo '<h2>Testing Image Creation:</h2>';
    
    try {
        // Try to create a simple image
        $image = imagecreatetruecolor(100, 100);
        imagefilledrectangle($image, 0, 0, 100, 100, imagecolorallocate($image, 255, 255, 255));
        
        // Draw a red rectangle
        imagerectangle($image, 10, 10, 90, 90, imagecolorallocate($image, 255, 0, 0));
        
        // Output to browser
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);
        
        echo '<p style="color: green;">✓ Successfully created test image</p>';
        echo '<img src="data:image/png;base64,' . base64_encode($imageData) . '" alt="Test Image">';
        
        // Try WebP if supported
        if (function_exists('imagewebp')) {
            $image = imagecreatetruecolor(100, 100);
            imagefilledrectangle($image, 0, 0, 100, 100, imagecolorallocate($image, 255, 255, 255));
            imagerectangle($image, 10, 10, 90, 90, imagecolorallocate($image, 0, 0, 255));
            
            // Output to browser
            ob_start();
            imagewebp($image, null, 80);
            $imageData = ob_get_clean();
            imagedestroy($image);
            
            echo '<p style="color: green;">✓ Successfully created WebP test image</p>';
            echo '<img src="data:image/webp;base64,' . base64_encode($imageData) . '" alt="WebP Test Image">';
        }
        
    } catch (Exception $e) {
        echo '<p style="color: red;">Error creating test image: ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    
} else {
    echo '<p style="color: red;">✗ GD extension is NOT installed</p>';
    echo '<p>You need to install GD library before you can use image manipulation features.</p>';
    
    if (PHP_OS == 'WINNT') {
        echo '<h2>Installation Instructions for Windows:</h2>';
        echo '<ol>';
        echo '<li>Open php.ini (typically in C:\php)</li>';
        echo '<li>Find and uncomment the line: ";extension=gd"</li>';
        echo '<li>Restart your web server</li>';
        echo '</ol>';
    } else {
        echo '<h2>Installation Instructions for Linux:</h2>';
        echo '<ol>';
        echo '<li>Ubuntu/Debian: <code>sudo apt-get install php-gd</code></li>';
        echo '<li>CentOS/RHEL: <code>sudo yum install php-gd</code></li>';
        echo '<li>Restart your web server</li>';
        echo '</ol>';
    }
}

echo '<h2>PHP Version:</h2>';
echo '<p>' . phpversion() . '</p>';

// Check Intervention Image package
echo '<h2>Intervention Image Check:</h2>';
if (file_exists(__DIR__ . '/../vendor/intervention/image')) {
    echo '<p style="color: green;">✓ Intervention Image package is installed</p>';
    
    // Check Intervention Image version
    $composerLock = file_get_contents(__DIR__ . '/../composer.lock');
    $composerData = json_decode($composerLock, true);
    
    $interventionVersion = null;
    foreach ($composerData['packages'] as $package) {
        if ($package['name'] === 'intervention/image') {
            $interventionVersion = $package['version'];
            break;
        }
    }
    
    if ($interventionVersion) {
        echo '<p>Version: ' . htmlspecialchars($interventionVersion) . '</p>';
    }
} else {
    echo '<p style="color: red;">✗ Intervention Image package is NOT installed</p>';
    echo '<p>Run: <code>composer require intervention/image</code></p>';
}
?>