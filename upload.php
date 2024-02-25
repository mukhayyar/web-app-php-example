<?php
require_once 'config.php';
require 'vendor/autoload.php'; // Include AWS SDK
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

// Connect to MySQL database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    
    // Upload image to S3 if provided
    $image_url = '';
    if ($_FILES['image']['size'] > 0) {
        
        $s3 = new S3Client([
            'version' => 'latest',
            'region' => AWS_REGION,
            'credentials' => [
                'key' => AWS_ACCESS_KEY,
                'secret' => AWS_SECRET_KEY,
            ],
        ]);
        
        $file_name = basename($_FILES["image"]["name"]);
        $file_tmp_name = $_FILES["image"]["tmp_name"];
        $upload_path = 'uploads/' . $file_name;
        
        try {
            $result = $s3->putObject([
                'Bucket' => S3_BUCKET,
                'Key' => $upload_path,
                'Body' => fopen($file_tmp_name, 'rb'),
                'ACL' => 'public-read'
            ]);
            $image_url = $result->get('ObjectURL');
        } catch (S3Exception $e) {
            die("Error uploading file: " . $e->getMessage());
        }
    }
    
    // Insert note into database
    $sql = "INSERT INTO notes (title, content, image_url) VALUES ('$title', '$content', '$image_url')";
    if ($conn->query($sql) === TRUE) {
        header('Location: index.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
