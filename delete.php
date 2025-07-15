<?php
require 'connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Get photo filename before deleting the record
    $stmt = $conn->prepare("SELECT photo FROM students WHERE id = ?");
    $stmt->execute([$id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    // Delete the student record
    $deleteStmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $deleteStmt->execute([$id]);

    // Delete the photo file (if exists)
    if ($student && !empty($student['photo'])) {
        $photoPath = 'photos/' . $student['photo'];
        if (file_exists($photoPath)) {
            unlink($photoPath); // delete file
        }
    }

    header("Location: index.php?deleted=1");
    exit;
} else {
    echo "No ID provided.";
}
