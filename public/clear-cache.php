<?php
// Set error reporting to show all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Laravel Cache Clearing Tool</h1>";

// Get the document root and parent directories
$documentRoot = $_SERVER['DOCUMENT_ROOT']; // This is public_html/micheweni-pemba
$parentDir = dirname(dirname($documentRoot)); // Go up two levels to get to domain/
$weteDir = $parentDir . '/micheweni-pemba'; // This is domain/micheweni-pemba

echo "<p>Document Root: " . htmlspecialchars($documentRoot) . "</p>";
echo "<p>Parent Directory: " . htmlspecialchars($parentDir) . "</p>";
echo "<p>Micheweni Directory: " . htmlspecialchars($weteDir) . "</p>";

// Try to run artisan commands
echo "<h2>Clearing Laravel Cache</h2>";

// Function to run artisan command
function runArtisanCommand($weteDir, $command) {
    $output = [];
    $returnVar = 0;
    
    exec("cd " . escapeshellarg($weteDir) . " && php artisan $command", $output, $returnVar);
    
    echo "<p>Command: <code>php artisan $command</code></p>";
    echo "<p>Result: " . ($returnVar === 0 ? "<span style='color:green'>Success</span>" : "<span style='color:red'>Failed (code: $returnVar)</span>") . "</p>";
    
    if (!empty($output)) {
        echo "<pre>" . htmlspecialchars(implode("\n", $output)) . "</pre>";
    }
    
    return $returnVar === 0;
}

// Try each artisan command
$commands = [
    'clear-compiled' => 'Clear compiled classes',
    'cache:clear' => 'Clear application cache',
    'config:clear' => 'Clear config cache',
    'route:clear' => 'Clear route cache',
    'view:clear' => 'Clear view cache'
];

foreach ($commands as $command => $description) {
    echo "<h3>$description</h3>";
    runArtisanCommand($weteDir, $command);
}

// Manual cache clearing
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
        echo "<h3>Clearing " . htmlspecialchars($dir) . "</h3>";
        
        // Get all files except . and ..
        $files = array_diff(scandir($dir), ['.', '..', '.gitignore']);
        
        if (empty($files)) {
            echo "<p>Directory is already empty</p>";
        } else {
            $deletedCount = 0;
            $failedCount = 0;
            
            foreach ($files as $file) {
                $path = $dir . '/' . $file;
                if (is_file($path)) {
                    if (unlink($path)) {
                        $deletedCount++;
                    } else {
                        $failedCount++;
                    }
                }
            }
            
            echo "<p>Deleted $deletedCount files" . ($failedCount > 0 ? ", failed to delete $failedCount files" : "") . "</p>";
        }
    } else {
        echo "<h3>Directory not found: " . htmlspecialchars($dir) . "</h3>";
    }
}

// Check if opcache is enabled and clear it
if (function_exists('opcache_reset')) {
    echo "<h2>Clearing OPcache</h2>";
    if (opcache_reset()) {
        echo "<p style='color:green'>OPcache cleared successfully</p>";
    } else {
        echo "<p style='color:orange'>Failed to clear OPcache</p>";
    }
}

echo "<h2>Done!</h2>";
echo "<p>Cache clearing completed. Your application should now recognize any changes you've made.</p>";

// Check if Intervention Image is available
echo "<h2>Checking Intervention Image</h2>";

// Try to include the autoloader
$autoloaderPaths = [
    $weteDir . '/vendor/autoload.php',
    dirname(dirname($_SERVER['DOCUMENT_ROOT'])) . '/micheweni-pemba/vendor/autoload.php',
    $_SERVER['DOCUMENT_ROOT'] . '/../vendor/autoload.php'
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
        } else {
            echo "<p style='color:green'>Intervention Image v2 detected</p>";
        }
    } else {
        echo "<p style='color:red'>Intervention Image is not installed</p>";
    }
}

echo "<p><a href='javascript:history.back()'>Go Back</a></p>"; 