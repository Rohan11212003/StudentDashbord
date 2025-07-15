<?php
require 'connect.php';

// Check if GD extension is loaded
if (!extension_loaded('gd')) {
    die('Error: GD extension is not enabled in PHP. Please enable it in your php.ini and restart the server.');
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize inputs
    $name        = $_POST['name'] ?? '';
    $email       = $_POST['email'] ?? '';
    $program     = $_POST['program'] ?? '';
    $year        = $_POST['year'] ?? '';
    $phone       = $_POST['phone'] ?? '';
    $start_date  = $_POST['start_date'] ?? null;
    $end_date    = $_POST['end_date'] ?? null;
    $cgpa        = $_POST['cgpa'] ?? null;
    $address     = $_POST['address'] ?? '';
    $photoName   = '';

    // Handle photo upload
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'photos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $tmpName = $_FILES['photo']['tmp_name'];
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($ext, $allowed)) {
            $msg = urlencode("Unsupported file type.");
            header("Location: add.php?error=$msg");
            exit;
        }

        // Load image based on extension
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $srcImage = imagecreatefromjpeg($tmpName);
                break;
            case 'png':
                $srcImage = imagecreatefrompng($tmpName);
                break;
            case 'gif':
                $srcImage = imagecreatefromgif($tmpName);
                break;
            default:
                $msg = urlencode("Unsupported image format.");
                header("Location: add.php?error=$msg");
                exit;
        }

        if (!$srcImage) {
            $msg = urlencode("Failed to load image for resizing.");
            header("Location: add.php?error=$msg");
            exit;
        }

        // Resize to 300x300
        $desiredWidth = 300;
        $desiredHeight = 300;

        $resizedImage = imagecreatetruecolor($desiredWidth, $desiredHeight);

        // Preserve transparency for PNG and GIF
        if ($ext === 'png' || $ext === 'gif') {
            imagecolortransparent($resizedImage, imagecolorallocatealpha($resizedImage, 0, 0, 0, 127));
            imagealphablending($resizedImage, false);
            imagesavealpha($resizedImage, true);
        }

        // Resize
        $srcWidth = imagesx($srcImage);
        $srcHeight = imagesy($srcImage);

        imagecopyresampled(
            $resizedImage, $srcImage,
            0, 0, 0, 0,
            $desiredWidth, $desiredHeight,
            $srcWidth, $srcHeight
        );

        // Save resized image
        $photoName = uniqid('photo_', true) . '.' . $ext;
        $destination = $uploadDir . $photoName;

        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($resizedImage, $destination, 90); // quality 90%
                break;
            case 'png':
                imagepng($resizedImage, $destination);
                break;
            case 'gif':
                imagegif($resizedImage, $destination);
                break;
        }

        // Free memory
        imagedestroy($srcImage);
        imagedestroy($resizedImage);
    } else {
        $msg = urlencode("Photo upload failed.");
        header("Location: add.php?error=$msg");
        exit;
    }

    // Insert student info into database
    $sql = "INSERT INTO students 
            (name, email, program, year, phone, start_date, end_date, cgpa, address, photo)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $name, $email, $program, $year, $phone,
        $start_date, $end_date, $cgpa, $address, $photoName
    ]);

    // Redirect back with success flag
    header("Location: index.php?saved=1");
    exit;
}
?>
