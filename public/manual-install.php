<?php
// Set error reporting to show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Intervention Image Manual Installation</h1>";

// Get the document root and parent directories
$documentRoot = $_SERVER['DOCUMENT_ROOT']; // This is public_html/micheweni-pemba
$parentDir = dirname(dirname($documentRoot)); // Go up two levels to get to domain/
$weteDir = $parentDir . '/micheweni-pemba'; // This is domain/micheweni-pemba

echo "<p>Document Root: " . htmlspecialchars($documentRoot) . "</p>";
echo "<p>Parent Directory: " . htmlspecialchars($parentDir) . "</p>";
echo "<p>Micheweni Directory: " . htmlspecialchars($weteDir) . "</p>";

// Check if vendor directory exists
$vendorDir = $weteDir . '/vendor';
if (!is_dir($vendorDir)) {
    echo "<p style='color:red'>Vendor directory not found at: " . htmlspecialchars($vendorDir) . "</p>";
    echo "<p>Please make sure your Laravel application is properly installed.</p>";
} else {
    echo "<p style='color:green'>Vendor directory found</p>";
}

// Check if composer.json exists
$composerJsonPath = $weteDir . '/composer.json';
if (!file_exists($composerJsonPath)) {
    echo "<p style='color:red'>composer.json not found at: " . htmlspecialchars($composerJsonPath) . "</p>";
} else {
    echo "<p style='color:green'>composer.json found</p>";
    
    // Read composer.json
    $composerJson = json_decode(file_get_contents($composerJsonPath), true);
    
    // Check if intervention/image is in composer.json
    if (isset($composerJson['require']['intervention/image'])) {
        echo "<p style='color:green'>intervention/image is already in composer.json: " . 
            htmlspecialchars($composerJson['require']['intervention/image']) . "</p>";
    } else {
        echo "<p style='color:orange'>intervention/image is not in composer.json</p>";
        
        // Add intervention/image to composer.json
        if (!isset($composerJson['require'])) {
            $composerJson['require'] = [];
        }
        
        $composerJson['require']['intervention/image'] = "^3.0";
        
        // Save updated composer.json
        if (is_writable($composerJsonPath)) {
            file_put_contents($composerJsonPath, json_encode($composerJson, JSON_PRETTY_PRINT));
            echo "<p style='color:green'>Added intervention/image to composer.json</p>";
        } else {
            echo "<p style='color:red'>Cannot write to composer.json. Please add the following line manually:</p>";
            echo "<pre>\"intervention/image\": \"^3.0\"</pre>";
        }
    }
}

// Check if FileUploader.php exists and has the correct path
$fileUploaderPath = $weteDir . '/app/Traits/FileUploader.php';
if (!file_exists($fileUploaderPath)) {
    echo "<p style='color:red'>FileUploader.php not found at: " . htmlspecialchars($fileUploaderPath) . "</p>";
} else {
    echo "<p style='color:green'>FileUploader.php found</p>";
    
    // Read FileUploader.php
    $fileUploaderContent = file_get_contents($fileUploaderPath);
    
    // Check if it has the tryLoadInterventionImage method
    if (strpos($fileUploaderContent, 'tryLoadInterventionImage') !== false) {
        echo "<p style='color:green'>FileUploader.php already has the tryLoadInterventionImage method</p>";
    } else {
        echo "<p style='color:orange'>FileUploader.php does not have the tryLoadInterventionImage method</p>";
        echo "<p>Please update your FileUploader.php with the latest version.</p>";
    }
}

// Display manual installation instructions
echo "<h2>Manual Installation Instructions</h2>";
echo "<p>Since you're on a shared hosting environment, you may need to manually install Intervention Image:</p>";
echo "<ol>";
echo "<li>Connect to your server via FTP or File Manager</li>";
echo "<li>Navigate to your Laravel application root directory (domain/micheweni-pemba)</li>";
echo "<li>Run the following command via SSH or through your hosting panel's command interface:</li>";
echo "<pre>cd " . htmlspecialchars($weteDir) . " && composer require intervention/image:^3.0</pre>";
echo "<li>If you don't have SSH access, you can try using your hosting panel's Composer tool</li>";
echo "<li>Make sure the FileUploader.php trait is updated with the latest version</li>";
echo "<li>Clear your Laravel cache</li>";
echo "</ol>";

// Create a simple file to test if Intervention Image is available
echo "<h2>Testing Intervention Image</h2>";

// Try to include the autoloader
$autoloaderPaths = [
    $weteDir . '/vendor/autoload.php',
    dirname(dirname($_SERVER['DOCUMENT_ROOT'])) . '/micheweni-pemba/vendor/autoload.php',
    $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php',
    dirname(dirname(dirname(__DIR__))) . '/vendor/autoload.php'
];

$autoloaderFound = false;
foreach ($autoloaderPaths as $path) {
    if (file_exists($path)) {
        require_once $path;
        echo "<p style='color:green'>Autoloader found at: " . htmlspecialchars($path) . "</p>";
        $autoloaderFound = true;
        break;
    }
}

if (!$autoloaderFound) {
    echo "<p style='color:red'>Could not find autoloader</p>";
} else {
    // Check if Intervention Image is available
    if (class_exists('Intervention\Image\ImageManager')) {
        echo "<p style='color:green'>Intervention Image is installed!</p>";
        
        // Check which version
        if (class_exists('Intervention\Image\Drivers\Gd\Driver')) {
            echo "<p style='color:green'>Intervention Image v3 detected</p>";
            
            // Try to create a test image
            try {
                $manager = new Intervention\Image\ImageManager(
                    new Intervention\Image\Drivers\Gd\Driver()
                );
                $image = $manager->create(100, 100, '#ff0000');
                
                ob_start();
                echo $image->toJpeg();
                $imageData = ob_get_clean();
                
                echo "<p style='color:green'>Test image created successfully!</p>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='Test Image'>";
            } catch (Exception $e) {
                echo "<p style='color:red'>Error creating test image: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color:green'>Intervention Image v2 detected</p>";
            
            // Try to create a test image with v2
            try {
                $manager = new Intervention\Image\ImageManager(['driver' => 'gd']);
                
                // Use make method for v2
                $method = 'canvas';
                if (method_exists($manager, $method)) {
                    $image = $manager->$method(100, 100, '#0000ff');
                    
                    $imageData = (string)$image->encode('jpg');
                    
                    echo "<p style='color:green'>Test image created successfully!</p>";
                    echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='Test Image'>";
                } else {
                    echo "<p style='color:red'>Method 'canvas' not found</p>";
                }
            } catch (Exception $e) {
                echo "<p style='color:red'>Error creating test image: " . $e->getMessage() . "</p>";
            }
        }
    } else {
        echo "<p style='color:red'>Intervention Image is not installed</p>";
    }
} 