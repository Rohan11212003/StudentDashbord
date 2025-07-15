<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=students_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
