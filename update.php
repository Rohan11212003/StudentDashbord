<?php
require 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $program = $_POST['program'] ?? '';
    $year = $_POST['year'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $photoName = '';

    // Check if new photo uploaded
    if (!empty($_FILES['photo']['name'])) {
        $uploadDir = 'photos/';
        $tmpName = $_FILES['photo']['tmp_name'];
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','gif'];

        if (in_array(strtolower($ext), $allowed)) {
            $photoName = uniqid('photo_', true) . '.' . $ext;
            move_uploaded_file($tmpName, $uploadDir . $photoName);

            // Update including new photo
            $sql = "UPDATE students SET name=?, email=?, program=?, year=?, phone=?, photo=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$name, $email, $program, $year, $phone, $photoName, $id]);
        } else {
            die("Invalid file type.");
        }
    } else {
        // Update without changing photo
        $sql = "UPDATE students SET name=?, email=?, program=?, year=?, phone=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$name, $email, $program, $year, $phone, $id]);
    }

    header("Location: index.php?updated=1");
    exit;
}
