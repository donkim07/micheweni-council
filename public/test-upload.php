<?php

// Load composer autoloader
require __DIR__.'/../vendor/autoload.php';

use Illuminate\Http\UploadedFile;
use App\Traits\FileUploader;

// Create a class that uses the FileUploader trait
class TestUploader {
    use FileUploader;
    
    public function getPublicPath() {
        return __DIR__;
    }
}

// Make sure errors are displayed
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$message = '';
$imagePath = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    try {
        $file = $_FILES['image'];
        
        if ($file['error'] === UPLOAD_ERR_OK) {
            // Create a Laravel UploadedFile instance from the $_FILES data
            $uploadedFile = new UploadedFile(
                $file['tmp_name'],
                $file['name'],
                $file['type'],
                $file['error']
            );
            
            // Create an instance of our test class
            $uploader = new TestUploader();
            
            // Upload the file
            $imagePath = $uploader->uploadFile($uploadedFile, 'test-uploads');
            
            $message = '<div style="color: green; margin-bottom: 15px;">File uploaded successfully!</div>';
        } else {
            $message = '<div style="color: red; margin-bottom: 15px;">Upload error: ' . $file['error'] . '</div>';
        }
    } catch (Exception $e) {
        $message = '<div style="color: red; margin-bottom: 15px;">Error: ' . $e->getMessage() . '</div>';
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>File Upload Test</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 800px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        .btn { padding: 8px 15px; background: #4CAF50; color: white; border: none; cursor: pointer; }
        .images { display: flex; margin-top: 30px; gap: 20px; }
        .image-container { border: 1px solid #ddd; padding: 10px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>File Upload Test</h1>
        
        <?php echo $message; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="image">Select Image:</label>
                <input type="file" id="image" name="image" accept="image/*">
            </div>
            <button type="submit" class="btn">Upload</button>
        </form>
        
        <?php if ($imagePath): ?>
        <div class="images">
            <div class="image-container">
                <h3>Uploaded Image:</h3>
                <img src="<?php echo '/' . $imagePath; ?>" style="max-width: 300px;">
                <p>Path: <?php echo $imagePath; ?></p>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html> 