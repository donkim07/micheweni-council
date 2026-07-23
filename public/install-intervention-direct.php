<?php
// Set error reporting to show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Intervention Image DirectAdmin Installer</h1>";

// Check PHP version
$phpVersion = phpversion();
echo "<p>PHP Version: $phpVersion</p>";

// Get the document root and parent directories
$documentRoot = $_SERVER['DOCUMENT_ROOT']; // This is public_html/micheweni-pemba
$parentDir = dirname(dirname($documentRoot)); // Go up two levels to get to domain/
$weteDir = $parentDir . '/micheweni-pemba'; // This is domain/micheweni-pemba

echo "<p>Document Root: " . htmlspecialchars($documentRoot) . "</p>";
echo "<p>Parent Directory: " . htmlspecialchars($parentDir) . "</p>";
echo "<p>Micheweni Directory: " . htmlspecialchars($weteDir) . "</p>";

// Check if Composer exists
$composerPath = $weteDir . '/composer.phar';
$hasComposer = file_exists($composerPath);

if (!$hasComposer) {
    echo "<h2>Installing Composer</h2>";
    
    // Download composer
    $composerInstaller = file_get_contents('https://getcomposer.org/installer');
    if ($composerInstaller === false) {
        die("<p style='color:red'>Failed to download Composer installer</p>");
    }
    
    // Save installer
    $tempFile = $weteDir . '/composer-setup.php';
    if (file_put_contents($tempFile, $composerInstaller) === false) {
        die("<p style='color:red'>Failed to save Composer installer</p>");
    }
    
    // Run installer
    echo "<p>Running Composer installer...</p>";
    $output = [];
    $returnVar = 0;
    exec("cd " . escapeshellarg($weteDir) . " && php composer-setup.php", $output, $returnVar);
    
    if ($returnVar !== 0) {
        echo "<p style='color:red'>Failed to install Composer. Error code: $returnVar</p>";
        echo "<pre>" . implode("\n", $output) . "</pre>";
    } else {
        echo "<p style='color:green'>Composer installed successfully!</p>";
        $hasComposer = true;
    }
    
    // Clean up
    @unlink($tempFile);
} else {
    echo "<p style='color:green'>Composer is already installed</p>";
}

// Check if composer.json exists
$composerJsonPath = $weteDir . '/composer.json';
$hasComposerJson = file_exists($composerJsonPath);

if (!$hasComposerJson) {
    echo "<h2>Creating composer.json</h2>";
    
    $composerJson = [
        'require' => [
            'intervention/image' => '^3.0'
        ]
    ];
    
    if (file_put_contents($composerJsonPath, json_encode($composerJson, JSON_PRETTY_PRINT)) === false) {
        die("<p style='color:red'>Failed to create composer.json</p>");
    }
    
    echo "<p style='color:green'>composer.json created successfully</p>";
} else {
    echo "<p style='color:green'>composer.json already exists</p>";
    
    // Update composer.json to include intervention/image
    $composerJson = json_decode(file_get_contents($composerJsonPath), true);
    if (!isset($composerJson['require']['intervention/image'])) {
        echo "<h2>Updating composer.json</h2>";
        
        if (!isset($composerJson['require'])) {
            $composerJson['require'] = [];
        }
        
        $composerJson['require']['intervention/image'] = '^3.0';
        
        if (file_put_contents($composerJsonPath, json_encode($composerJson, JSON_PRETTY_PRINT)) === false) {
            die("<p style='color:red'>Failed to update composer.json</p>");
        }
        
        echo "<p style='color:green'>composer.json updated successfully</p>";
    } else {
        echo "<p style='color:green'>intervention/image is already in composer.json</p>";
    }
}

// Install Intervention Image
if ($hasComposer) {
    echo "<h2>Installing Intervention Image</h2>";
    
    $output = [];
    $returnVar = 0;
    
    // Try to run composer install
    exec("cd " . escapeshellarg($weteDir) . " && php composer.phar install --no-dev", $output, $returnVar);
    
    if ($returnVar !== 0) {
        echo "<p style='color:red'>Failed to install packages. Error code: $returnVar</p>";
        echo "<pre>" . implode("\n", $output) . "</pre>";
    } else {
        echo "<p style='color:green'>Packages installed successfully!</p>";
    }
}

// Check if Intervention Image is now installed
echo "<h2>Checking Installation</h2>";

// Try to include the autoloader
if (file_exists($weteDir . '/vendor/autoload.php')) {
    require_once $weteDir . '/vendor/autoload.php';
    echo "<p style='color:green'>Autoloader found</p>";
    
    // Check for Intervention Image classes
    if (class_exists('Intervention\Image\ImageManager')) {
        echo "<p style='color:green'>Intervention Image installed successfully!</p>";
        
        // Check for v3
        if (class_exists('Intervention\Image\Drivers\Gd\Driver')) {
            echo "<p style='color:green'>Intervention Image v3 detected</p>";
            
            // Test image creation
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
            
            // Test image creation with v2
            try {
                $manager = new Intervention\Image\ImageManager(['driver' => 'gd']);
                $image = $manager->canvas(100, 100, '#0000ff');
                
                $imageData = (string)$image->encode('jpg');
                
                echo "<p style='color:green'>Test image created successfully!</p>";
                echo "<img src='data:image/jpeg;base64," . base64_encode($imageData) . "' alt='Test Image'>";
            } catch (Exception $e) {
                echo "<p style='color:red'>Error creating test image: " . $e->getMessage() . "</p>";
            }
        }
    } else {
        echo "<p style='color:red'>Intervention Image not found</p>";
    }
} else {
    echo "<p style='color:red'>Autoloader not found</p>";
}

// Display next steps
echo "<h2>Next Steps</h2>";
echo "<ol>";
echo "<li>If installation was successful, you should see a test image above.</li>";
echo "<li>Upload the updated FileUploader.php to your server at micheweni-pemba/app/Traits/FileUploader.php</li>";
echo "<li>Clear your application cache by visiting <a href='clear-cache.php'>clear-cache.php</a></li>";
echo "</ol>";

// Create a cache clearing script
$cacheScript = <<<'EOD'
<?php
// Set error reporting to show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Cache Clearing Tool</h1>";

// Get the document root and parent directories
$documentRoot = $_SERVER['DOCUMENT_ROOT']; // This is public_html/micheweni-pemba
$parentDir = dirname(dirname($documentRoot)); // Go up two levels to get to domain/
$weteDir = $parentDir . '/micheweni-pemba'; // This is domain/micheweni-pemba

echo "<p>Document Root: " . htmlspecialchars($documentRoot) . "</p>";
echo "<p>Parent Directory: " . htmlspecialchars($parentDir) . "</p>";
echo "<p>Micheweni Directory: " . htmlspecialchars($weteDir) . "</p>";

// Try to run artisan commands
$output = [];
$returnVar = 0;

echo "<h2>Clearing Laravel Cache</h2>";

// Clear compiled classes
exec("cd " . escapeshellarg($weteDir) . " && php artisan clear-compiled", $output, $returnVar);
echo "<p>Clear compiled result: " . ($returnVar === 0 ? "Success" : "Failed") . "</p>";

// Clear application cache
$output = [];
$returnVar = 0;
exec("cd " . escapeshellarg($weteDir) . " && php artisan cache:clear", $output, $returnVar);
echo "<p>Cache clear result: " . ($returnVar === 0 ? "Success" : "Failed") . "</p>";

// Clear config cache
$output = [];
$returnVar = 0;
exec("cd " . escapeshellarg($weteDir) . " && php artisan config:clear", $output, $returnVar);
echo "<p>Config clear result: " . ($returnVar === 0 ? "Success" : "Failed") . "</p>";

// Clear route cache
$output = [];
$returnVar = 0;
exec("cd " . escapeshellarg($weteDir) . " && php artisan route:clear", $output, $returnVar);
echo "<p>Route clear result: " . ($returnVar === 0 ? "Success" : "Failed") . "</p>";

// Clear view cache
$output = [];
$returnVar = 0;
exec("cd " . escapeshellarg($weteDir) . " && php artisan view:clear", $output, $returnVar);
echo "<p>View clear result: " . ($returnVar === 0 ? "Success" : "Failed") . "</p>";

echo "<h2>Manual Cache Clearing</h2>";

// Define cache directories
$cacheDirs = [
    $weteDir . '/bootstrap/cache',
    $weteDir . '/storage/framework/cache',
    $weteDir . '/storage/framework/views',
    $weteDir . '/storage/framework/sessions'
];

foreach ($cacheDirs as $dir) {
    if (is_dir($dir)) {
        echo "<p>Clearing $dir...</p>";
        
        // Get all files except . and ..
        $files = array_diff(scandir($dir), ['.', '..', '.gitignore']);
        
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            if (is_file($path)) {
                if (unlink($path)) {
                    echo "<p style='color:green'>Deleted: $file</p>";
                } else {
                    echo "<p style='color:red'>Failed to delete: $file</p>";
                }
            }
        }
    } else {
        echo "<p>Directory not found: $dir</p>";
    }
}

echo "<h2>Done!</h2>";
echo "<p>Cache clearing completed. Your application should now recognize the Intervention Image package.</p>";
echo "<p><a href='javascript:history.back()'>Go Back</a></p>";
EOD;

file_put_contents($documentRoot . '/clear-cache.php', $cacheScript);
echo "<p style='color:green'>Created cache clearing script: clear-cache.php</p>"; 